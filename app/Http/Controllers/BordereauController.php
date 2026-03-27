<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        // ========== TAUX DE CONVERSION ==========
        // Ratio opportunités gagnées (avec contrat) / opportunités affectées
        $taux_conversion = $total_opp_affectees > 0 
            ? round(($opp_gagnees / $total_opp_affectees) * 100, 2) 
            : 0;

        // ========== SCORE ==========
        // Score combiné
        $score = $this->calculerScore($conseiller, $opp_gagnees, $taux_conversion);

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
     * Calcule un score pour le conseiller (0-100)
     */
    private function calculerScore($conseiller, $opp_traitees, $taux_conversion)
    {
        // Score basé sur : nombre d'opportunités traitées + taux de conversion
        $score_opp = min($opp_traitees * 5, 50); // Max 50 points pour les opportunités
        $score_taux = $taux_conversion; // Max 50 points = 100% taux de conversion

        return round($score_opp + ($score_taux / 2), 2);
    }
}
