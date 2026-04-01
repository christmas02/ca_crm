<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load('role');

        $data = [];
        $data['stats'] = $this->getCustomStats($user);

        if ($user->isAdmin() || $user->isLead()) {
            $query = Opportunity::query();

            if ($user->isLead()) {
                $query->where('team_id', $user->team_id);
            }

            $data['totalOpportunities'] = (clone $query)->count();
            $data['groupCounts'] = $this->getGroupCounts($user);

            $data['recentOpportunities'] = (clone $query)
                ->with(['status', 'assignee', 'creator'])
                ->latest()
                ->take(10)
                ->get();

            $data['totalClients'] = Client::count();
            $data['totalUsers'] = $user->isAdmin() ? User::count() : User::where('team_id', $user->team_id)->count();
        }

        if ($user->isAgentConseil() || $user->isAgentConseilRenouvellement()) {
            $data['assignedOpportunities'] = Opportunity::where('assigned_to', $user->id)
                ->with(['status'])
                ->latest()
                ->get();
        }

   

        if ($user->isAgentTerrain()) {
            $data['createdOpportunities'] = Opportunity::where('created_by', $user->id)
                ->with(['status', 'assignee'])
                ->latest()
                ->get();
        }
        return view('dashboard', $data);
    }

    /**
     * Retourne les statistiques personnalisées en fonction du rôle de l'utilisateur
     */
    private function getCustomStats($user)
    {
        if ($user->isAgentConseil() || $user->isAgentConseilRenouvellement()) {
            return $this->getAgentConseilStats($user);
        } elseif ($user->isAgentTerrain()) {
            return $this->getAgentTerrainStats($user);
        } elseif ($user->isLead()) {
            return $this->getLeadStats($user);
        } elseif ($user->isAdmin()) {
            return $this->getAdminStats($user);
        }

        return [];
    }

    /**
     * Récupère les collections d'opportunités pour Agent Conseil
     */
    private function getAgentConseilOpportunitiesCollections($user)
    {
        $today = Carbon::now()->startOfDay();
        $weekEnd = Carbon::now()->addDays(7)->endOfDay();

        $rendezVousStatus = Status::where('slug', 'rendez_vous')->first();
        $nouvelleStatus = Status::where('slug', 'nouvelle')->first();

        $collections = [
            // Rendez-vous du jour
            'rendezVous' => Opportunity::where('assigned_to', $user->id)
                ->whereDate('relance', $today)
                ->with(['status', 'assignee', 'client'])
                ->get(),
            
            // Échéances cette semaine
            'echeances' => Opportunity::where('assigned_to', $user->id)
                ->whereNotNull('echeance')
                ->whereDate('echeance', '>=', $today->format('Y-m-d'))
                ->whereDate('echeance', '<=', $weekEnd->format('Y-m-d'))
                ->with(['status', 'assignee', 'client'])
                ->get(),
            
            // Nouvelles opportunités
            'nouvelles' => Opportunity::join('assignments', 'opportunities.id', '=', 'assignments.opportunity_id')
                ->where('assignments.assigned_to', $user->id)
                ->when($nouvelleStatus, fn($q) => $q->where('opportunities.status_id', $nouvelleStatus->id))
                ->whereDate('assignments.date_affect', $today)
                ->select('opportunities.*')
                ->with(['status', 'assignee', 'client'])
                ->get(),
        ];

        return $collections;
    }

    /**
     * Statistiques pour Agent Conseil
     */
    private function getAgentConseilStats($user)
    {
        $collections = $this->getAgentConseilOpportunitiesCollections($user);
        
        $rendezVousStatus = Status::where('slug', 'rendez_vous')->first();
        $nouvelleStatus = Status::where('slug', 'nouvelle')->first();

        $rendezVousCount = $collections['rendezVous']->count();
        $echeancesCount = $collections['echeances']->count();
        $nouvellesCount = $collections['nouvelles']->count();
        $totalCount = $rendezVousCount + $echeancesCount + $nouvellesCount;

        return [
            // Rendez-vous du jour
            [
                'label' => 'Rendez-vous du jour',
                'value' => $rendezVousCount,
                'color' => $rendezVousStatus?->color ?? '#3b82f6',
                'icon' => '📞'
            ],
            // Échéances urgentes cette semaine
            [
                'label' => 'Échéances cette semaine',
                'value' => $echeancesCount,
                'color' => '#f59e0b',
                'icon' => '⚠️'
            ],
            // Nouvelles opportunités assignées
            [
                'label' => 'Nouvelles opportunités',
                'value' => $nouvellesCount,
                'color' => $nouvelleStatus?->color ?? '#fbbf24',
                'icon' => '✨'
            ],
            // Total opportunités assignées (sum of previous values)
            [
                'label' => 'Total opportunités',
                'value' => $totalCount,
                'color' => '#6366f1',
                'icon' => '📊'
            ],
        ];
    }

    /**
     * Statistiques pour Agent Terrain
     */
    private function getAgentTerrainStats($user)
    {
        $nouvelleStatus = Status::where('slug', 'nouvelle')->first();
        $gagneStatus = Status::where('slug', 'gagne')->first();
        $perdusStatus = Status::where('slug', 'perdus')->first();

        return [
            // Nouvelles opportunités créées
            [
                'label' => 'Nouvelles créées',
                'value' => Opportunity::where('created_by', $user->id)
                    ->when($nouvelleStatus, fn($q) => $q->where('status_id', $nouvelleStatus->id))
                    ->count(),
                'color' => $nouvelleStatus?->color ?? '#fbbf24',
                'icon' => '✨',
                'url' => route('opportunities.index', ['created_by' => $user->id, 'status' => 'nouvelle'])
            ],
            // Opportunités gagnées
            [
                'label' => 'Opportunités gagnées',
                'value' => Opportunity::where('created_by', $user->id)
                    ->when($gagneStatus, fn($q) => $q->where('status_id', $gagneStatus->id))
                    ->count(),
                'color' => $gagneStatus?->color ?? '#10b981',
                'icon' => '🏆',
                'url' => route('opportunities.index', ['created_by' => $user->id, 'status' => 'gagne'])
            ],
            // Opportunités perdues
            [
                'label' => 'Opportunités perdues',
                'value' => Opportunity::where('created_by', $user->id)
                    ->when($perdusStatus, fn($q) => $q->where('status_id', $perdusStatus->id))
                    ->count(),
                'color' => $perdusStatus?->color ?? '#ef4444',
                'icon' => '❌',
                'url' => route('opportunities.index', ['created_by' => $user->id, 'status' => 'perdus'])
            ],
            // Total créées
            [
                'label' => 'Total créées',
                'value' => Opportunity::where('created_by', $user->id)->count(),
                'color' => '#8b5cf6',
                'icon' => '📋',
                'url' => route('opportunities.index', ['created_by' => $user->id])
            ],
        ];
    }

    /**
     * Statistiques pour Lead
     */
    private function getLeadStats($user)
    {
        $gagneStatus = Status::where('slug', 'gagne')->first();
        $perdusStatus = Status::where('slug', 'perdus')->first();

        $teamQuery = Opportunity::where('team_id', $user->team_id);

        return [
            // Total opportunités de l'équipe
            [
                'label' => 'Total équipe',
                'value' => (clone $teamQuery)->count(),
                'color' => '#6366f1',
                'icon' => '👥',
                'url' => route('opportunities.index', ['team_id' => $user->team_id])
            ],
            // Opportunités assignées
            [
                'label' => 'Assignées',
                'value' => (clone $teamQuery)->whereNotNull('assigned_to')->count(),
                'color' => '#3b82f6',
                'icon' => '📌',
                'url' => route('opportunities.index', ['team_id' => $user->team_id, 'assigned' => 'yes'])
            ],
            // Opportunités gagnées
            [
                'label' => 'Gagnées',
                'value' => (clone $teamQuery)
                    ->when($gagneStatus, fn($q) => $q->where('status_id', $gagneStatus->id))
                    ->count(),
                'color' => $gagneStatus?->color ?? '#10b981',
                'icon' => '🏆',
                'url' => route('opportunities.index', ['team_id' => $user->team_id, 'status' => 'gagne'])
            ],
            // Opportunités perdues
            [
                'label' => 'Perdues',
                'value' => (clone $teamQuery)
                    ->when($perdusStatus, fn($q) => $q->where('status_id', $perdusStatus->id))
                    ->count(),
                'color' => $perdusStatus?->color ?? '#ef4444',
                'icon' => '❌',
                'url' => route('opportunities.index', ['team_id' => $user->team_id, 'status' => 'perdus'])
            ],
        ];
    }

    /**
     * Statistiques pour Admin
     */
    private function getAdminStats($user)
    {
        $gagneStatus = Status::where('slug', 'gagne')->first();
        $perdusStatus = Status::where('slug', 'perdus')->first();

        return [
            // Total opportunités
            [
                'label' => 'Total opportunités',
                'value' => Opportunity::count(),
                'color' => '#6366f1',
                'icon' => '📊',
                'url' => route('opportunities.index')
            ],
            // Total clients
            [
                'label' => 'Total clients',
                'value' => Client::count(),
                'color' => '#3b82f6',
                'icon' => '👤',
                'url' => route('clients.index')
            ],
            // Total utilisateurs
            [
                'label' => 'Total utilisateurs',
                'value' => User::count(),
                'color' => '#8b5cf6',
                'icon' => '👨‍💼',
                'url' => route('users.index')
            ],
            // Taux de conversion (Gagnées)
            [
                'label' => 'Opportunités gagnées',
                'value' => Opportunity::when($gagneStatus, fn($q) => $q->where('status_id', $gagneStatus->id))->count(),
                'color' => $gagneStatus?->color ?? '#10b981',
                'icon' => '🏆',
                'url' => route('opportunities.index', ['status' => 'gagne'])
            ],
        ];
    }

    private function getGroupCounts($user)
    {
        $groups = Status::select('group', DB::raw('MIN(color) as color'), DB::raw('MIN(`order`) as `order`'))
            ->groupBy('group')
            ->orderBy('order')
            ->get();

        foreach ($groups as $group) {
            $statusIds = Status::where('group', $group->group)->pluck('id');
            $q = Opportunity::whereIn('status_id', $statusIds);

            if ($user->isLead()) {
                $q->where('team_id', $user->team_id);
            } elseif ($user->isAgentConseil()) {
                $q->where('assigned_to', $user->id);
            } elseif ($user->isAgentTerrain()) {
                $q->where('created_by', $user->id);
            }

            $group->count = $q->count();
        }

        return $groups;
    }

    public function getStatOpportunities(Request $request)
    {
        $user = $request->user();
        $statIndex = $request->get('stat_index', 0);

        $collections = $this->getAgentConseilOpportunitiesCollections($user);

        $opportunities = collect();

        if ($statIndex == 0) {
            $opportunities = $collections['rendezVous'];
        } elseif ($statIndex == 1) {
            $opportunities = $collections['echeances'];
        } elseif ($statIndex == 2) {
            $opportunities = $collections['nouvelles'];
        } elseif ($statIndex == 3) {
            // Total (union des 3 précédentes)
            $opportunities = $collections['rendezVous']
                ->concat($collections['echeances'])
                ->concat($collections['nouvelles'])
                ->unique('id');
        }

        return response()->json([
            'opportunities' => $opportunities->map(function($opp) {
                return [
                    'id' => $opp->id,
                    'full_name' => $opp->full_name,
                    'telephone' => $opp->telephone,
                    'status' => $opp->status,
                    'plaque_immatriculation' => $opp->plaque_immatriculation,
                    'echeance' => $opp->echeance,
                    'relance' => $opp->relance,
                ];
            })
        ]);
    }
}
