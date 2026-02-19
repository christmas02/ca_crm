<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load('role');

        $data = [];

        if ($user->isAdmin() || $user->isLead()) {
            $query = Opportunity::query();

            if ($user->isLead()) {
                $query->where('team_id', $user->team_id);
            }

            $data['totalOpportunities'] = (clone $query)->count();

            // Grouper les compteurs par group (Nouvelle, Rendez-vous, Poursuivre, Gagné, Perdus, Reporter)
            $data['groupCounts'] = $this->getGroupCounts($user);

            $data['recentOpportunities'] = (clone $query)
                ->with(['status', 'assignee', 'creator'])
                ->latest()
                ->take(10)
                ->get();

            $gagneStatusIds = Status::where('slug', 'gagne')->pluck('id');
            $data['totalClients'] = Client::count();
            $data['totalUsers'] = $user->isAdmin() ? User::count() : User::where('team_id', $user->team_id)->count();
        }

        if ($user->isAgentConseil()) {
            $data['assignedOpportunities'] = Opportunity::where('assigned_to', $user->id)
                ->with(['status'])
                ->latest()
                ->get();
            $data['groupCounts'] = $this->getGroupCounts($user);
        }

        if ($user->isAgentTerrain()) {
            $data['createdOpportunities'] = Opportunity::where('created_by', $user->id)
                ->with(['status', 'assignee'])
                ->latest()
                ->get();
            $data['groupCounts'] = $this->getGroupCounts($user);
        }

        return view('dashboard', $data);
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
}
