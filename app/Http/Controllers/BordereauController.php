<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class BordereauController extends Controller
{
    /**
     * Affiche le tableau de bord des bordereaux
     */
    public function index(Request $request)
    {
        // Contrôler l'accès (Lead et Admin uniquement)
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        return view('bordereaux.index');
    }

    /**
     * Affiche le bordereau conseil avec les métriques par conseiller
     */
    public function conseil(Request $request)
    {
        // Contrôler l'accès
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        // Récupérer les filtres de date
        // Si une date spécifique est fournie, l'utiliser pour la plage
        if ($request->filled('date_specifique')) {
            $dateDebut = Carbon::parse($request->date_specifique)->startOfDay();
            $dateFin = Carbon::parse($request->date_specifique)->endOfDay();
        } else {
            $dateDebut = $request->filled('date_debut') ? Carbon::parse($request->date_debut) : Carbon::now()->startOfMonth();
            $dateFin = $request->filled('date_fin') ? Carbon::parse($request->date_fin) : Carbon::now()->endOfDay();
        }

        // Récupérer les conseillers avec les rôles 'agent_conseil' et 'agent_conseil_renouvellement'
        $conseillers = User::with('role')
            ->whereHas('role', function($query) {
                $query->whereIn('slug', ['agent_conseil', 'agent_conseil_renouvellement']);
            })
            ->where('actif', true)
            ->get();

        // Enrichir avec les métriques
        $donnees = $conseillers->map(function ($conseiller) use ($dateDebut, $dateFin) {
            return $this->calculerMetriques($conseiller, $dateDebut, $dateFin);
        });


        // Statuts importants
        $statusGagne = Status::where('slug', 'gagne')->first();
        $statusRenouvellement = Status::where('slug', 'renouvellement')->first();

        return view('bordereaux.conseil', compact('donnees', 'statusGagne', 'statusRenouvellement', 'dateDebut', 'dateFin'));
    }

    /**
     * Calcule les métriques pour un conseiller selon les définitions exactes
     */
    private function calculerMetriques($conseiller, $dateDebut = null, $dateFin = null)
    {
        // Valeurs par défaut
        if (!$dateDebut) {
            $dateDebut = Carbon::now()->startOfMonth();
        }
        if (!$dateFin) {
            $dateFin = Carbon::now()->endOfDay();
        }

        // ========== OPP. DU JOUR ==========
        // Point de départ: la table assignments (historisation)
        // Trouvé les assignations ACTIVES du conseiller pendant la période
        // Puis récupérer les opportunités correspondantes
        $opp_jour = Assignment::where('assigned_to', $conseiller->id)
            ->where('status', 'active')
            ->whereBetween('date_affect', [$dateDebut, $dateFin])
            ->pluck('opportunity_id')
            ->unique()
            ->count();

        // ========== OPP. MODIFIÉES/COMMENTÉES ==========
        // Compte les opportunités du conseiller sur lesquelles il a commenté pendant la période
        $opp_modifiees = Opportunity::where('assigned_to', $conseiller->id)
            ->whereHas('comments', function($query) use ($conseiller, $dateDebut, $dateFin) {
                $query->where('user_id', $conseiller->id)
                      ->whereBetween('created_at', [$dateDebut, $dateFin]);
            })
            ->count();

        // ========== TOTAL RENOUVELLEMENT ==========
        // Nombre d'opportunités qui possèdent DÉJÀ un contrat ET status = renouvellement
          $statusGagne = Status::where('slug', 'gagne')->first();
        $total_renouvellement = \App\Models\Contract::where('created_by', $conseiller->id)
            ->where('contract_number', 'LIKE', 'CTR-%-%')
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->whereHas('opportunity', function($query) use ($statusGagne) {
                $query->where('status_id', $statusGagne?->id);
            })
            ->distinct('opportunity_id')
            ->count();

        // ========== OPP. GAGNÉES ==========
        // Point de départ: la table contracts
        // Contrats créés par ce conseiller pendant la période
        // Joindre avec opportunities pour vérifier le statut = gagne
        $statusGagne = Status::where('slug', 'gagne')->first();
        $opp_gagnees = \App\Models\Contract::where('created_by', $conseiller->id)
            ->where('contract_number', 'LIKE', 'CTR-%')
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->whereHas('opportunity', function($query) use ($statusGagne) {
                $query->where('status_id', $statusGagne?->id);
            })
            ->distinct('opportunity_id')
            ->count();

        // ========== TOTAL OPPORTUNITÉS AFFECTÉES (dans la période) ==========
        // Compte les opportunités qui ont été assignées au conseil pendant la période
        // Soit directement (assigned_to) soit via la table assignments
        $total_opp_affectees = Opportunity::where(function($query) use ($conseiller, $dateDebut, $dateFin) {
            // Soit l'opportunité est assignée directement ET a été créée dans la période
            $query->where(function($q) use ($conseiller, $dateDebut, $dateFin) {
                $q->where('assigned_to', $conseiller->id)
                  ->whereBetween('created_at', [$dateDebut, $dateFin]);
            })
            // Soit l'opportunité a eu une assignation à ce conseiller qui a date_affect dans la période
            ->orWhereHas('assignments', function($subQuery) use ($conseiller, $dateDebut, $dateFin) {
                $subQuery->where('assigned_to', $conseiller->id)
                         ->whereBetween('date_affect', [$dateDebut, $dateFin]);
            });
        })
        ->distinct()
        ->count();


        // Compter les contrats renouvelés (CTR-XXXXX-N)
        $contrats_renouveles = \App\Models\Contract::where('created_by', $conseiller->id)
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->whereHas('opportunity', function($query) use ($statusGagne) {
                $query->where('status_id', $statusGagne?->id);
            })
            ->whereRaw("contract_number REGEXP '^CTR-[A-Z0-9]+-[0-9]+$'")
            ->count();

        // Compter les contrats nouveaux (CTR-XXXXX)
        $contrats_nouveaux = \App\Models\Contract::where('created_by', $conseiller->id)
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->whereHas('opportunity', function($query) use ($statusGagne) {
                $query->where('status_id', $statusGagne?->id);
            })
            ->whereRaw("contract_number REGEXP '^CTR-[A-Z0-9]+$' AND contract_number NOT REGEXP '^CTR-[A-Z0-9]+-[0-9]+$'")
            ->count();

        // ========== TAUX DE CONVERSION ==========
        // Ratio opportunités gagnées (avec contrat) / opportunités affectées
        $taux_conversion = $total_opp_affectees > 0 
            ? round(($opp_gagnees / $total_opp_affectees) * 100, 2) 
            : 0;

        // ========== SCORE ==========
        // Score = (contrats renouvelés / 3) + contrats nouveaux
        $score = round(($contrats_renouveles / 3) + $contrats_nouveaux, 2);

        return [
            'id' => $conseiller->id,
            'nom' => $conseiller->name,
            'opp_jour' => $opp_jour,
            'opp_modifiees' => $opp_modifiees,
            'total_renouvellement' => $total_renouvellement,
            'opp_gagnees' => $opp_gagnees,
            'taux_conversion' => $taux_conversion,
            'score' => $score,
            'total_opp_affectees' => $total_opp_affectees,
        ];
    }

    /**
     * Affiche le bordereau détaillé des contrats gagnés
     */
    public function contratsGagnes(Request $request)
    {
        // Contrôler l'accès
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        // Récupérer les filtres de date
        if ($request->filled('date_specifique')) {
            $dateDebut = Carbon::parse($request->date_specifique)->startOfDay();
            $dateFin = Carbon::parse($request->date_specifique)->endOfDay();
        } else {
            $dateDebut = $request->filled('date_debut') ? Carbon::parse($request->date_debut) : Carbon::now()->startOfMonth();
            $dateFin = $request->filled('date_fin') ? Carbon::parse($request->date_fin) : Carbon::now()->endOfDay();
        }

        // Statut 'gagne'
        $statusGagne = Status::where('slug', 'gagne')->first();

        // Récupérer les conseillers
        $conseillers = User::with('role')
            ->whereHas('role', function($query) {
                $query->whereIn('slug', ['agent_conseil', 'agent_conseil_renouvellement']);
            })
            ->where('actif', true)
            ->get();

        // Construire les métriques par conseiller
        $donnees = $conseillers->map(function ($conseiller) use ($dateDebut, $dateFin, $statusGagne) {
            // Opportunités traitées
            $opp_traite = Opportunity::where(function($query) use ($conseiller, $dateDebut, $dateFin) {
                $query->where(function($q) use ($conseiller, $dateDebut, $dateFin) {
                    $q->where('assigned_to', $conseiller->id)
                      ->whereBetween('created_at', [$dateDebut, $dateFin]);
                })
                ->orWhereHas('assignments', function($subQuery) use ($conseiller, $dateDebut, $dateFin) {
                    $subQuery->where('assigned_to', $conseiller->id)
                             ->whereBetween('date_affect', [$dateDebut, $dateFin]);
                });
            })->distinct()->count();

            // Contrats renouvelés (CTR-XXXXX-N)
            $contrats_renouveles = \App\Models\Contract::where('created_by', $conseiller->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->whereHas('opportunity', function($query) use ($statusGagne) {
                    $query->where('status_id', $statusGagne?->id);
                })
                ->where('contract_number', 'LIKE', 'CTR-%-%')
                ->count();

            // Contrats nouveaux (CTR-XXXXX)
            $contrats_nouveaux = \App\Models\Contract::where('created_by', $conseiller->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->whereHas('opportunity', function($query) use ($statusGagne) {
                    $query->where('status_id', $statusGagne?->id);
                })
                ->where('contract_number', 'LIKE', 'CTR-%')
                ->whereRaw("contract_number NOT LIKE 'CTR-%--%'")
                ->count();

            // Score
            $score = round(($contrats_renouveles / 3) + $contrats_nouveaux, 2);

            // Taux affectées (opp_traite / total_opp)
            $total_opp = Opportunity::where(function($query) use ($conseiller) {
                $query->where('assigned_to', $conseiller->id)
                      ->orWhereHas('assignments', function($q) use ($conseiller) {
                          $q->where('assigned_to', $conseiller->id);
                      });
            })->distinct()->count();

            $taux_affectees = $total_opp > 0 
                ? round(($opp_traite / $total_opp) * 100, 2) 
                : 0;

            // Taux traitées (opp_traite pendant la période / opp_traite total)
            $taux_traitees = $total_opp > 0 
                ? round(($opp_traite / $total_opp) * 100, 2) 
                : 0;

            // Taux conversion
            $total_contrats = $contrats_renouveles + $contrats_nouveaux;
            $taux_conversion = $opp_traite > 0 
                ? round(($total_contrats / $opp_traite) * 100, 2) 
                : 0;

            // Primes (depuis BD)
            $contrats = \App\Models\Contract::where('created_by', $conseiller->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->whereHas('opportunity', function($query) use ($statusGagne) {
                    $query->where('status_id', $statusGagne?->id);
                })
                ->get(['net_premium', 'ttc_premium']);

            $prime_nette = $contrats->sum('net_premium') ?? 0;
            $prime_ttc = $contrats->sum('ttc_premium') ?? 0;
            $prime_moyenne = $total_contrats > 0 ? $prime_nette / $total_contrats : 0;

            return [
                'id' => $conseiller->id,
                'nom' => $conseiller->name,
                'opp_traite' => $opp_traite,
                'contrat_nouveau' => $contrats_nouveaux,
                'contrat_renouveller' => $contrats_renouveles,
                'score' => $score,
                'taux_affectees' => $taux_affectees,
                'taux_traitees' => $taux_traitees,
                'taux_conversion' => $taux_conversion,
                'prime_nette' => $prime_nette,
                'prime_ttc' => $prime_ttc,
                'prime_moyenne' => $prime_moyenne,
            ];
        });

        return view('bordereaux.contrats-gagnes', 
            compact('donnees', 'dateDebut', 'dateFin'));
    }

    /**
     * Affiche le bordereau des contrats gagnés par équipe
     */
    public function contratsGagnesEquipe(Request $request)
    {
        // Contrôler l'accès
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        // Récupérer les filtres de date
        if ($request->filled('date_specifique')) {
            $dateDebut = Carbon::parse($request->date_specifique)->startOfDay();
            $dateFin = Carbon::parse($request->date_specifique)->endOfDay();
        } else {
            $dateDebut = $request->filled('date_debut') ? Carbon::parse($request->date_debut) : Carbon::now()->startOfMonth();
            $dateFin = $request->filled('date_fin') ? Carbon::parse($request->date_fin) : Carbon::now()->endOfDay();
        }

        // Statut 'gagne'
        $statusGagne = Status::where('slug', 'gagne')->first();

        // Récupérer toutes les équipes avec leurs membres
        $teams = \App\Models\Team::with(['users' => function($q) {
            $q->where('actif', true);
        }])->get();

        // Construire les métriques par équipe
        $donnees = $teams->map(function ($team) use ($dateDebut, $dateFin, $statusGagne) {
            $memberIds = $team->users->pluck('id')->toArray();
            
            // Si équipe sans membres, retourner 0
            if (empty($memberIds)) {
                return [
                    'nom' => $team->name,
                    'opp_traite' => 0,
                    'contrat_nouveau' => 0,
                    'contrat_renouveller' => 0,
                    'score' => 0,
                    'taux_affectees' => 0,
                    'taux_traitees' => 0,
                    'taux_conversion' => 0,
                    'prime_nette' => 0,
                    'prime_ttc' => 0,
                    'prime_moyenne' => 0,
                ];
            }

            // Opportunités traitées
            $opp_traite = Opportunity::where(function($query) use ($memberIds, $dateDebut, $dateFin) {
                $query->where(function($q) use ($memberIds, $dateDebut, $dateFin) {
                    $q->whereIn('assigned_to', $memberIds)
                      ->whereBetween('created_at', [$dateDebut, $dateFin]);
                })
                ->orWhereHas('assignments', function($subQuery) use ($memberIds, $dateDebut, $dateFin) {
                    $subQuery->whereIn('assigned_to', $memberIds)
                             ->whereBetween('date_affect', [$dateDebut, $dateFin]);
                });
            })->distinct()->count();

            // Contrats renouvelés
            $contrats_renouveles = \App\Models\Contract::whereIn('created_by', $memberIds)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->whereHas('opportunity', function($query) use ($statusGagne) {
                    $query->where('status_id', $statusGagne?->id);
                })
                ->where('contract_number', 'LIKE', 'CTR-%-%')
                ->count();

            // Contrats nouveaux
            $contrats_nouveaux = \App\Models\Contract::whereIn('created_by', $memberIds)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->whereHas('opportunity', function($query) use ($statusGagne) {
                    $query->where('status_id', $statusGagne?->id);
                })
                ->where('contract_number', 'LIKE', 'CTR-%')
                ->whereRaw("contract_number NOT LIKE 'CTR-%--%'")
                ->count();

            // Score
            $score = round(($contrats_renouveles / 3) + $contrats_nouveaux, 2);

            // Taux affectées et traitées
            $total_opp = Opportunity::where(function($query) use ($memberIds) {
                $query->whereIn('assigned_to', $memberIds)
                      ->orWhereHas('assignments', function($q) use ($memberIds) {
                          $q->whereIn('assigned_to', $memberIds);
                      });
            })->distinct()->count();

            $taux_affectees = $total_opp > 0 
                ? round(($opp_traite / $total_opp) * 100, 2) 
                : 0;

            $taux_traitees = $total_opp > 0 
                ? round(($opp_traite / $total_opp) * 100, 2) 
                : 0;

            // Taux conversion
            $total_contrats = $contrats_renouveles + $contrats_nouveaux;
            $taux_conversion = $opp_traite > 0 
                ? round(($total_contrats / $opp_traite) * 100, 2) 
                : 0;

            // Primes
            $contrats = \App\Models\Contract::whereIn('created_by', $memberIds)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->whereHas('opportunity', function($query) use ($statusGagne) {
                    $query->where('status_id', $statusGagne?->id);
                })
                ->get(['net_premium', 'ttc_premium']);

            $prime_nette = $contrats->sum('net_premium') ?? 0;
            $prime_ttc = $contrats->sum('ttc_premium') ?? 0;
            $prime_moyenne = $total_contrats > 0 ? $prime_nette / $total_contrats : 0;

            return [
                'nom' => $team->name,
                'opp_traite' => $opp_traite,
                'contrat_nouveau' => $contrats_nouveaux,
                'contrat_renouveller' => $contrats_renouveles,
                'score' => $score,
                'taux_affectees' => $taux_affectees,
                'taux_traitees' => $taux_traitees,
                'taux_conversion' => $taux_conversion,
                'prime_nette' => $prime_nette,
                'prime_ttc' => $prime_ttc,
                'prime_moyenne' => $prime_moyenne,
            ];
        })->filter(function($team) {
            // Filtrer les équipes vides
            return $team['opp_traite'] > 0 || $team['contrat_nouveau'] > 0 || $team['contrat_renouveller'] > 0;
        });

        return view('bordereaux.contrats-gagnes-equipe', 
            compact('donnees', 'dateDebut', 'dateFin'));
    }

    /**
     * Affiche la comparaison de performances entre deux périodes
     */
    public function statsComparatives(Request $request)
    {
        // Contrôler l'accès
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        // Définir les deux périodes (par défaut: mois actuel vs mois précédent)
        $maintenant = Carbon::now();
        
        // Période 1 (par défaut: mois précédent)
        if ($request->filled('p1_debut')) {
            $p1_debut = Carbon::parse($request->p1_debut)->startOfDay();
        } else {
            $p1_debut = $maintenant->copy()->subMonth()->startOfMonth();
        }
        
        if ($request->filled('p1_fin')) {
            $p1_fin = Carbon::parse($request->p1_fin)->endOfDay();
        } else {
            $p1_fin = $maintenant->copy()->subMonth()->endOfMonth();
        }

        // Période 2 (par défaut: mois actuel)
        if ($request->filled('p2_debut')) {
            $p2_debut = Carbon::parse($request->p2_debut)->startOfDay();
        } else {
            $p2_debut = $maintenant->copy()->startOfMonth();
        }
        
        if ($request->filled('p2_fin')) {
            $p2_fin = Carbon::parse($request->p2_fin)->endOfDay();
        } else {
            $p2_fin = $maintenant->copy()->endOfDay();
        }

        // Récupérer les statuts
        $statusGagne = Status::where('slug', 'gagne')->first();

        // Fonction pour calculer les métriques d'une période
        $calculerMetriques = function($dateDebut, $dateFin) use ($statusGagne) {
            // 1. Nombre total d'opportunités enregistrées (toutes les opp created dans la période)
            $opp_total = Opportunity::whereBetween('created_at', [$dateDebut, $dateFin])->count();

            // 2. Opportunités traitées (opp modifiées/assignées durant la période)
            $opp_traite = Opportunity::whereBetween('updated_at', [$dateDebut, $dateFin])->count();

            // 3. Opportunités gagnées (status = 'gagne')
            $opp_gagnee = Opportunity::whereBetween('created_at', [$dateDebut, $dateFin])
                ->where('status_id', $statusGagne?->id)
                ->count();

            // 4. Taux de conversion global (opp_gagnée / opp_total)
            $taux_conversion = $opp_total > 0 ? round(($opp_gagnee / $opp_total) * 100, 2) : 0;

            // 5. Total affaires nouvelles (somme prime_nette des contrats NOUVEAUX CTR-XXXXX)
            $affaires_nouvelles = \App\Models\Contract::whereBetween('created_at', [$dateDebut, $dateFin])
                ->where('contract_number', 'LIKE', 'CTR-%')
                ->whereRaw("contract_number NOT LIKE 'CTR-%--%'")
                ->sum('net_premium');

            // 6. Chiffres d'affaires (somme prime_nette TOTALE tous contrats)
            $chiffre_affaires = \App\Models\Contract::whereBetween('created_at', [$dateDebut, $dateFin])
                ->sum('net_premium');

            // 7. Commission totale (10% des primes nettes)
            $commission_total = round($chiffre_affaires * 0.10, 2);

            // 8. Nombre de contrats totaux
            $nombre_contrats = \App\Models\Contract::whereBetween('created_at', [$dateDebut, $dateFin])->count();

            // 9. Prime moyenne par contrat
            $prime_moyenne = $nombre_contrats > 0 ? round($chiffre_affaires / $nombre_contrats, 2) : 0;

            // 10. Contrats nouveaux et renouvelés pour score
            $contrats_nouveaux = \App\Models\Contract::whereBetween('created_at', [$dateDebut, $dateFin])
                ->where('contract_number', 'LIKE', 'CTR-%')
                ->whereRaw("contract_number NOT LIKE 'CTR-%--%'")
                ->count();

            $contrats_renouveles = \App\Models\Contract::whereBetween('created_at', [$dateDebut, $dateFin])
                ->where('contract_number', 'LIKE', 'CTR-%-%')
                ->count();

            // 11. Score moyen par équipe = (contrats_renouvelés / 3) + contrats_nouveaux
            $score_moyen_equipe = round(($contrats_renouveles / 3) + $contrats_nouveaux, 2);

            return [
                'opp_total' => $opp_total,
                'opp_traite' => $opp_traite,
                'opp_gagnee' => $opp_gagnee,
                'taux_conversion' => $taux_conversion,
                'affaires_nouvelles' => round($affaires_nouvelles, 2),
                'chiffre_affaires' => round($chiffre_affaires, 2),
                'commission_total' => $commission_total,
                'nombre_contrats' => $nombre_contrats,
                'prime_moyenne' => $prime_moyenne,
                'score_moyen_equipe' => $score_moyen_equipe,
            ];
        };

        // Calculer les métriques pour les deux périodes
        $metriques_p1 = $calculerMetriques($p1_debut, $p1_fin);
        $metriques_p2 = $calculerMetriques($p2_debut, $p2_fin);

        // Calculer les variations (%)
        $variations = [];
        foreach ($metriques_p1 as $key => $valeur_p1) {
            $valeur_p2 = $metriques_p2[$key];
            
            if ($valeur_p1 == 0) {
                if ($valeur_p2 > 0) {
                    $variations[$key] = 100; // +100% si passage de 0 à quelque chose
                } else {
                    $variations[$key] = 0; // Pas de variation si les deux sont 0
                }
            } else {
                $variations[$key] = round((($valeur_p2 - $valeur_p1) / $valeur_p1) * 100, 2);
            }
        }

        return view('bordereaux.stats-comparatives', compact(
            'metriques_p1', 'metriques_p2', 'variations',
            'p1_debut', 'p1_fin', 'p2_debut', 'p2_fin'
        ));
    }

    /**
     * Affiche le bordereau des agents terrain avec suivi des performances
     */
    public function agentsTerrain(Request $request)
    {
        // Contrôler l'accès
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        // Récupérer les filtres de date
        $dateDebut = $request->filled('date_debut') ? Carbon::parse($request->date_debut) : Carbon::now()->startOfMonth();
        $dateFin = $request->filled('date_fin') ? Carbon::parse($request->date_fin) : Carbon::now()->endOfDay();

        // Récupérer tous les agents terrain
        $agentsTerrain = User::where('role_id', function($q) {
            $q->select('id')->from('roles')->where('slug', 'agent_terrain')->limit(1);
        })->active()->get();

        // Calculer les métriques pour chaque agent
        $metriques = $agentsTerrain->map(function($agent) use ($dateDebut, $dateFin) {
            // Opportunités remontées
            $oppRemontees = Opportunity::where('created_by', $agent->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->count();

            // Opportunités avec carte grise disponible (urlcarte_grise_terrain renseigné)
            $nbCartesGrises = Opportunity::where('created_by', $agent->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->whereNotNull('urlcarte_grise_terrain')
                ->count();

            // Discours OK (statut_discours = 'ok')
            $discoursOk = Opportunity::where('created_by', $agent->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->where('statut_discours', 'ok')
                ->count();

            // Discours NOK (statut_discours = 'nok')
            $discoursNok = Opportunity::where('created_by', $agent->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->where('statut_discours', 'nok')
                ->count();

            // Cartes grises: no flag (statut_carte_grise = null ou ne contient pas 'ok'/'nok')
            $cgNoFlag = Opportunity::where('created_by', $agent->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->where(function($q) {
                    $q->whereNull('statut_carte_grise')
                      ->orWhere('statut_carte_grise', 'no_flag');
                })
                ->count();

            // Cartes grises: ok (statut_carte_grise = 'ok')
            $cgOk = Opportunity::where('created_by', $agent->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->where('statut_carte_grise', 'ok')
                ->count();

            // Cartes grises: nok (statut_carte_grise = 'nok')
            $cgNok = Opportunity::where('created_by', $agent->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->where('statut_carte_grise', 'nok')
                ->count();

            // Opportunités hors cible (source = 'hors_cible' ou autre logique)
            $oppHorsCible = Opportunity::where('created_by', $agent->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->where('source', 'hors_cible')
                ->count();

            // Opportunités perdues (statut != 'gagne' mais avec status 'abandon' ou similaire)
            $oppPerdue = Opportunity::where('created_by', $agent->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->whereHas('status', function($q) {
                    $q->whereIn('slug', ['abandon', 'perdu']);
                })
                ->count();

            // Nombre de jours travaillés - calculé par nombre de jours uniques avec des opportunités
            $nbJoursTravailles = Opportunity::where('created_by', $agent->id)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->selectRaw('DATE(created_at)')
                ->distinct()
                ->count();

            // Contrats gagnés
            $contratsGagnes = \App\Models\Contract::whereHas('opportunity', function($q) use ($agent, $dateDebut, $dateFin) {
                $q->where('created_by', $agent->id)
                  ->whereBetween('opportunities.created_at', [$dateDebut, $dateFin])
                  ->whereHas('status', function($sq) {
                      $sq->where('slug', 'gagne');
                  });
            })->count();

            // Calcul des ratios
            $nbContratsParOpp = $oppRemontees > 0 ? round(($contratsGagnes / $oppRemontees) * 100, 2) : 0;
            $tauxQualification = $oppRemontees > 0 ? round((($oppRemontees - $oppHorsCible - $oppPerdue) / $oppRemontees) * 100, 2) : 0;

            return [
                'agent_id' => $agent->id,
                'agent_nom' => $agent->name,
                'agent_identification' => $agent->identification,
                'opp_remontees' => $oppRemontees,
                'nb_cartes_grises' => $nbCartesGrises,
                'discours_ok' => $discoursOk,
                'discours_nok' => $discoursNok,
                'cg_no_flag' => $cgNoFlag,
                'cg_ok' => $cgOk,
                'cg_nok' => $cgNok,
                'opp_hors_cible' => $oppHorsCible,
                'opp_perdue' => $oppPerdue,
                'nb_jours_travailles' => $nbJoursTravailles,
                'contrats_gagnes' => $contratsGagnes,
                'nb_contrats_par_opp' => $nbContratsParOpp,
                'taux_qualification' => $tauxQualification,
            ];
        })->sortByDesc('opp_remontees');

        return view('bordereaux.agents-terrain', compact(
            'metriques', 'dateDebut', 'dateFin'
        ));
    }

    /**
     * Exporte les données de conseil en PDF ou Excel
     */
    public function exportConseil(Request $request)
    {
        // Contrôler l'accès
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $format = $request->query('format', 'excel');
        
        // Récupérer les filtres de date
        if ($request->filled('date_specifique')) {
            $dateDebut = Carbon::parse($request->date_specifique)->startOfDay();
            $dateFin = Carbon::parse($request->date_specifique)->endOfDay();
        } else {
            $dateDebut = $request->filled('date_debut') ? Carbon::parse($request->date_debut) : Carbon::now()->startOfMonth();
            $dateFin = $request->filled('date_fin') ? Carbon::parse($request->date_fin) : Carbon::now()->endOfDay();
        }

        // Récupérer les conseillers
        $conseillers = User::with('role')
            ->whereHas('role', function($query) {
                $query->whereIn('slug', ['agent_conseil', 'agent_conseil_renouvellement']);
            })
            ->where('actif', true)
            ->get();

        // Enrichir avec les métriques
        $donnees = $conseillers->map(function ($conseiller) use ($dateDebut, $dateFin) {
            return $this->calculerMetriques($conseiller, $dateDebut, $dateFin);
        });

        if ($format === 'excel') {
            return $this->exportToExcel($donnees, $dateDebut, $dateFin);
        } elseif ($format === 'pdf') {
            return $this->exportToPdf($donnees, $dateDebut, $dateFin);
        }

        abort(400, 'Format invalide');
    }

    /**
     * Exporte en Excel (CSV)
     */
    private function exportToExcel($donnees, $dateDebut, $dateFin)
    {
        $filename = 'metriques_conseillers_' . $dateDebut->format('Y-m-d') . '_' . $dateFin->format('Y-m-d') . '.csv';
        
        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function() use ($donnees) {
            $file = fopen('php://output', 'w');
            
            // En-têtes
            fputcsv($file, array(
                'Nom du conseiller',
                'Opp. du jour',
                'Opp. Traitées',
                'Renouvellement',
                'Opp. gagnées',
                'Score',
                'Taux conversion (%)'
            ), ';');

            // Données
            foreach ($donnees as $row) {
                fputcsv($file, array(
                    $row['nom'],
                    $row['opp_jour'],
                    $row['opp_modifiees'],
                    $row['total_renouvellement'],
                    $row['opp_gagnees'],
                    $row['score'],
                    round($row['taux_conversion'] * 100, 2)
                ), ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Exporte en PDF
     */
    private function exportToPdf($donnees, $dateDebut, $dateFin)
    {
        $filename = 'metriques_conseillers_' . $dateDebut->format('Y-m-d') . '_' . $dateFin->format('Y-m-d') . '.pdf';
        
        // Rendre la vue HTML
        $html = view('pdf.conseil', [
            'donnees' => $donnees,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin
        ])->render();
        
        // Générer le PDF avec DomPDF
        $pdf = Pdf::loadHTML($html);
        return $pdf->download($filename);
    }

    /**
     * Exporte les contrats gagnés en PDF ou Excel
     */
    public function exportContratsGagnes(Request $request)
    {
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $format = $request->query('format', 'excel');
        
        $dateDebut = $request->filled('date_debut') ? Carbon::parse($request->date_debut) : Carbon::now()->startOfMonth();
        $dateFin = $request->filled('date_fin') ? Carbon::parse($request->date_fin) : Carbon::now()->endOfDay();
        $statusGagne = Status::where('slug', 'gagne')->first();

        $conseillers = User::with('role')
            ->whereHas('role', function($query) {
                $query->whereIn('slug', ['agent_conseil', 'agent_conseil_renouvellement']);
            })
            ->where('actif', true)
            ->get();

        $donnees = $conseillers->map(function ($conseiller) use ($dateDebut, $dateFin, $statusGagne) {
            return $this->calculerMetriquesContratsGagnes($conseiller, $dateDebut, $dateFin, $statusGagne);
        })->filter(fn($item) => !empty($item));

        if ($format === 'excel') {
            return $this->exportCSV($donnees, $dateDebut, $dateFin, 'contrats-gagnes');
        } else {
            return $this->exportSimplePDF($donnees, $dateDebut, $dateFin, 'Contrats Gagnés par Conseiller');
        }
    }

    /**
     * Calcul des métriques pour contrats gagnés
     */
    private function calculerMetriquesContratsGagnes($conseiller, $dateDebut, $dateFin, $statusGagne)
    {
        $opp_traite = Opportunity::where(function($query) use ($conseiller, $dateDebut, $dateFin) {
            $query->where(function($q) use ($conseiller, $dateDebut, $dateFin) {
                $q->where('assigned_to', $conseiller->id)
                  ->whereBetween('created_at', [$dateDebut, $dateFin]);
            })
            ->orWhereHas('assignments', function($subQuery) use ($conseiller, $dateDebut, $dateFin) {
                $subQuery->where('assigned_to', $conseiller->id)
                         ->whereBetween('date_affect', [$dateDebut, $dateFin]);
            });
        })->distinct()->count();

        $contrats_renouveles = \App\Models\Contract::where('created_by', $conseiller->id)
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->whereHas('opportunity', function($query) use ($statusGagne) {
                $query->where('status_id', $statusGagne?->id);
            })
            ->where('contract_number', 'LIKE', 'CTR-%-%')
            ->count();

        $contrats_nouveaux = \App\Models\Contract::where('created_by', $conseiller->id)
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->whereHas('opportunity', function($query) use ($statusGagne) {
                $query->where('status_id', $statusGagne?->id);
            })
            ->where('contract_number', 'LIKE', 'CTR-%')
            ->whereRaw("contract_number NOT LIKE 'CTR-%--%'")
            ->count();

        $total_opp = Opportunity::where(function($query) use ($conseiller) {
            $query->where('assigned_to', $conseiller->id)
                  ->orWhereHas('assignments', function($q) use ($conseiller) {
                      $q->where('assigned_to', $conseiller->id);
                  });
        })->distinct()->count();

        $contrats = \App\Models\Contract::where('created_by', $conseiller->id)
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->whereHas('opportunity', function($query) use ($statusGagne) {
                $query->where('status_id', $statusGagne?->id);
            })
            ->get(['net_premium', 'ttc_premium']);

        $total_contrats = $contrats_renouveles + $contrats_nouveaux;
        $score = round(($contrats_renouveles / 3) + $contrats_nouveaux, 2);
        $taux_affectees = $total_opp > 0 ? round(($opp_traite / $total_opp) * 100, 2) : 0;
        $taux_traitees = $total_opp > 0 ? round(($opp_traite / $total_opp) * 100, 2) : 0;
        $taux_conversion = $opp_traite > 0 ? round(($total_contrats / $opp_traite) * 100, 2) : 0;

        return [
            'nom' => $conseiller->name,
            'opp_traite' => $opp_traite,
            'contrat_nouveau' => $contrats_nouveaux,
            'contrat_renouveller' => $contrats_renouveles,
            'score' => $score,
            'taux_affectees' => $taux_affectees,
            'taux_traitees' => $taux_traitees,
            'taux_conversion' => $taux_conversion,
            'prime_nette' => $contrats->sum('net_premium') ?? 0,
            'prime_ttc' => $contrats->sum('ttc_premium') ?? 0,
            'prime_moyenne' => $total_contrats > 0 ? ($contrats->sum('net_premium') ?? 0) / $total_contrats : 0,
        ];
    }

    /**
     * Exporte les contrats gagnés par équipe
     */
    public function exportContratsGagnesEquipe(Request $request)
    {
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $format = $request->query('format', 'excel');
        
        $dateDebut = $request->filled('date_debut') ? Carbon::parse($request->date_debut) : Carbon::now()->startOfMonth();
        $dateFin = $request->filled('date_fin') ? Carbon::parse($request->date_fin) : Carbon::now()->endOfDay();
        $statusGagne = Status::where('slug', 'gagne')->first();

        $teams = \App\Models\Team::with(['users' => function($q) {
            $q->where('actif', true);
        }])->get();

        $donnees = $teams->map(function ($team) use ($dateDebut, $dateFin, $statusGagne) {
            $memberIds = $team->users->pluck('id')->toArray();
            
            if (empty($memberIds)) {
                return null;
            }

            $opp_traite = Opportunity::where(function($query) use ($memberIds, $dateDebut, $dateFin) {
                $query->where(function($q) use ($memberIds, $dateDebut, $dateFin) {
                    $q->whereIn('assigned_to', $memberIds)
                      ->whereBetween('created_at', [$dateDebut, $dateFin]);
                })
                ->orWhereHas('assignments', function($subQuery) use ($memberIds, $dateDebut, $dateFin) {
                    $subQuery->whereIn('assigned_to', $memberIds)
                             ->whereBetween('date_affect', [$dateDebut, $dateFin]);
                });
            })->distinct()->count();

            $contrats_renouveles = \App\Models\Contract::whereIn('created_by', $memberIds)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->whereHas('opportunity', function($query) use ($statusGagne) {
                    $query->where('status_id', $statusGagne?->id);
                })
                ->where('contract_number', 'LIKE', 'CTR-%-%')
                ->count();

            $contrats_nouveaux = \App\Models\Contract::whereIn('created_by', $memberIds)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->whereHas('opportunity', function($query) use ($statusGagne) {
                    $query->where('status_id', $statusGagne?->id);
                })
                ->where('contract_number', 'LIKE', 'CTR-%')
                ->whereRaw("contract_number NOT LIKE 'CTR-%--%'")
                ->count();

            $total_opp = Opportunity::where(function($query) use ($memberIds) {
                $query->whereIn('assigned_to', $memberIds)
                      ->orWhereHas('assignments', function($q) use ($memberIds) {
                          $q->whereIn('assigned_to', $memberIds);
                      });
            })->distinct()->count();

            $contrats = \App\Models\Contract::whereIn('created_by', $memberIds)
                ->whereBetween('created_at', [$dateDebut, $dateFin])
                ->whereHas('opportunity', function($query) use ($statusGagne) {
                    $query->where('status_id', $statusGagne?->id);
                })
                ->get(['net_premium', 'ttc_premium']);

            $total_contrats = $contrats_renouveles + $contrats_nouveaux;
            $score = round(($contrats_renouveles / 3) + $contrats_nouveaux, 2);
            $taux_affectees = $total_opp > 0 ? round(($opp_traite / $total_opp) * 100, 2) : 0;
            $taux_traitees = $total_opp > 0 ? round(($opp_traite / $total_opp) * 100, 2) : 0;
            $taux_conversion = $opp_traite > 0 ? round(($total_contrats / $opp_traite) * 100, 2) : 0;

            return [
                'nom' => $team->name,
                'opp_traite' => $opp_traite,
                'contrat_nouveau' => $contrats_nouveaux,
                'contrat_renouveller' => $contrats_renouveles,
                'score' => $score,
                'taux_affectees' => $taux_affectees,
                'taux_traitees' => $taux_traitees,
                'taux_conversion' => $taux_conversion,
                'prime_nette' => $contrats->sum('net_premium') ?? 0,
                'prime_ttc' => $contrats->sum('ttc_premium') ?? 0,
                'prime_moyenne' => $total_contrats > 0 ? ($contrats->sum('net_premium') ?? 0) / $total_contrats : 0,
            ];
        })->filter(fn($item) => $item !== null);

        if ($format === 'excel') {
            return $this->exportCSV($donnees, $dateDebut, $dateFin, 'contrats-gagnes-equipe');
        } else {
            return $this->exportSimplePDF($donnees, $dateDebut, $dateFin, 'Contrats Gagnés par Équipe');
        }
    }

    /**
     * Exporte les stats comparatives
     */
    public function exportStatsComparatives(Request $request)
    {
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $format = $request->query('format', 'excel');
        
        $p1_debut = $request->filled('p1_debut') ? Carbon::parse($request->p1_debut) : Carbon::now()->subMonth()->startOfMonth();
        $p1_fin = $request->filled('p1_fin') ? Carbon::parse($request->p1_fin) : Carbon::now()->subMonth()->endOfMonth();
        $p2_debut = $request->filled('p2_debut') ? Carbon::parse($request->p2_debut) : Carbon::now()->startOfMonth();
        $p2_fin = $request->filled('p2_fin') ? Carbon::parse($request->p2_fin) : Carbon::now()->endOfDay();

        $filename = 'stats-comparatives_' . $p1_debut->format('Y-m-d') . '_' . $p1_fin->format('Y-m-d') . '_vs_' . $p2_debut->format('Y-m-d') . '_' . $p2_fin->format('Y-m-d');

        if ($format === 'excel') {
            return $this->exportCSVStatsComparatives($p1_debut, $p1_fin, $p2_debut, $p2_fin, $filename);
        } else {
            return $this->exportPDFStatsComparatives($p1_debut, $p1_fin, $p2_debut, $p2_fin, $filename);
        }
    }

    /**
     * Exporte les agents terrain
     */
    public function exportAgentsTerrain(Request $request)
    {
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $format = $request->query('format', 'excel');
        
        $dateDebut = $request->filled('date_debut') ? Carbon::parse($request->date_debut) : Carbon::now()->startOfMonth();
        $dateFin = $request->filled('date_fin') ? Carbon::parse($request->date_fin) : Carbon::now()->endOfDay();

        // Appel la même logique que agentsTerrain() pour récupérer les métriques
        // Cette partie aurait besoin d'être refactorisée mais pour l'instant retournons un simple CSV
        
        if ($format === 'excel') {
            return $this->exportSimpleCSVAgentsTerrain($dateDebut, $dateFin);
        } else {
            return $this->exportSimplePDFAgentsTerrain($dateDebut, $dateFin);
        }
    }

    /**
     * Exporte en CSV générique
     */
    private function exportCSV($donnees, $dateDebut, $dateFin, $name)
    {
        $filename = $name . '_' . $dateDebut->format('Y-m-d') . '_' . $dateFin->format('Y-m-d') . '.csv';
        
        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function() use ($donnees) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, array(
                'Nom',
                'Opp Traité',
                'Contrat Nouveau',
                'Contrat Renouvellement',
                'Score',
                'Taux Affectées (%)',
                'Taux Traitées (%)',
                'Taux Conversion (%)',
                'Prime Nette',
                'Prime TTC',
                'Prime Moyenne'
            ), ';');

            foreach ($donnees as $row) {
                fputcsv($file, array(
                    $row['nom'],
                    $row['opp_traite'],
                    $row['contrat_nouveau'],
                    $row['contrat_renouveller'],
                    round($row['score'], 2),
                    round($row['taux_affectees'], 2),
                    round($row['taux_traitees'], 2),
                    round($row['taux_conversion'], 2),
                    round($row['prime_nette'], 2),
                    round($row['prime_ttc'], 2),
                    round($row['prime_moyenne'], 2)
                ), ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Exporte PDF générique simple
     */
    private function exportSimplePDF($donnees, $dateDebut, $dateFin, $title)
    {
        $html = '<html><head><meta charset="UTF-8"><style>';
        $html .= 'body { font-family: Arial, sans-serif; margin: 20px; }';
        $html .= 'h1 { text-align: center; color: #1f2937; border-bottom: 2px solid #3b82f6; padding-bottom: 10px; }';
        $html .= 'table { width: 100%; border-collapse: collapse; margin-top: 20px; }';
        $html .= 'th { background-color: #3b82f6; color: white; padding: 10px; text-align: left; }';
        $html .= 'td { padding: 8px; border: 1px solid #ddd; }';
        $html .= 'tr:nth-child(even) { background-color: #f9f9f9; }';
        $html .= '.date-info { text-align: center; color: #666; margin-bottom: 20px; }';
        $html .= '</style></head><body>';
        
        $html .= '<h1>' . $title . '</h1>';
        $html .= '<div class="date-info">Période: ' . $dateDebut->format('d/m/Y') . ' - ' . $dateFin->format('d/m/Y') . '</div>';
        
        $html .= '<table>';
        $html .= '<thead><tr><th>Nom</th><th>Opp Traité</th><th>Contrat Nouveau</th><th>Contrat RN</th><th>Score</th><th>Taux Conv%</th><th>Prime Nette</th><th>Prime TTC</th></tr></thead><tbody>';
        
        foreach ($donnees as $row) {
            $html .= '<tr><td>' . $row['nom'] . '</td><td>' . $row['opp_traite'] . '</td><td>' . $row['contrat_nouveau'] . '</td><td>' . $row['contrat_renouveller'] . '</td><td>' . round($row['score'], 2) . '</td><td>' . round($row['taux_conversion'], 2) . '%</td><td>' . round($row['prime_nette'], 2) . '</td><td>' . round($row['prime_ttc'], 2) . '</td></tr>';
        }
        
        $html .= '</tbody></table></body></html>';
        
        $filename = strtolower(str_replace(' ', '-', $title)) . '_' . $dateDebut->format('Y-m-d') . '_' . $dateFin->format('Y-m-d') . '.pdf';
        $pdf = Pdf::loadHTML($html);
        return $pdf->download($filename);
    }

    /**
     * Exporte CSV stats comparatives
     */
    private function exportCSVStatsComparatives($p1_debut, $p1_fin, $p2_debut, $p2_fin, $filename)
    {
        $filename .= '.csv';
        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function() use ($p1_debut, $p1_fin, $p2_debut, $p2_fin) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, array(
                'Métrique',
                'Période 1 (' . $p1_debut->format('d/m/Y') . ' - ' . $p1_fin->format('d/m/Y') . ')',
                'Période 2 (' . $p2_debut->format('d/m/Y') . ' - ' . $p2_fin->format('d/m/Y') . ')',
                'Évolution (%)'
            ), ';');

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Exporte PDF stats comparatives
     */
    private function exportPDFStatsComparatives($p1_debut, $p1_fin, $p2_debut, $p2_fin, $filename)
    {
        $html = '<html><head><meta charset="UTF-8"><style>';
        $html .= 'body { font-family: Arial, sans-serif; margin: 20px; }';
        $html .= 'h1 { text-align: center; color: #1f2937; border-bottom: 2px solid #8b5cf6; padding-bottom: 10px; }';
        $html .= 'table { width: 100%; border-collapse: collapse; margin-top: 20px; }';
        $html .= 'th { background-color: #8b5cf6; color: white; padding: 10px; text-align: left; }';
        $html .= 'td { padding: 8px; border: 1px solid #ddd; }';
        $html .= 'tr:nth-child(even) { background-color: #f9f9f9; }';
        $html .= '</style></head><body>';
        
        $html .= '<h1>Comparaison de Périodes</h1>';
        $html .= '<p>Période 1: ' . $p1_debut->format('d/m/Y') . ' - ' . $p1_fin->format('d/m/Y') . '</p>';
        $html .= '<p>Période 2: ' . $p2_debut->format('d/m/Y') . ' - ' . $p2_fin->format('d/m/Y') . '</p>';
        
        $html .= '</body></html>';
        
        $filename .= '.pdf';
        $pdf = Pdf::loadHTML($html);
        return $pdf->download($filename);
    }

    /**
     * Exporte CSV agents terrain
     */
    private function exportSimpleCSVAgentsTerrain($dateDebut, $dateFin)
    {
        $filename = 'agents-terrain_' . $dateDebut->format('Y-m-d') . '_' . $dateFin->format('Y-m-d') . '.csv';
        
        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, array('Agent', 'Métrique', 'Valeur'), ';');
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Exporte PDF agents terrain
     */
    private function exportSimplePDFAgentsTerrain($dateDebut, $dateFin)
    {
        $html = '<html><head><meta charset="UTF-8"><style>';
        $html .= 'body { font-family: Arial, sans-serif; margin: 20px; }';
        $html .= 'h1 { text-align: center; color: #1f2937; border-bottom: 2px solid #f97316; padding-bottom: 10px; }';
        $html .= '</style></head><body>';
        $html .= '<h1>Performance Agents Terrain</h1>';
        $html .= '<p>Période: ' . $dateDebut->format('d/m/Y') . ' - ' . $dateFin->format('d/m/Y') . '</p>';
        $html .= '</body></html>';
        
        $filename = 'agents-terrain_' . $dateDebut->format('Y-m-d') . '_' . $dateFin->format('Y-m-d') . '.pdf';
        $pdf = Pdf::loadHTML($html);
        return $pdf->download($filename);
    }

}

