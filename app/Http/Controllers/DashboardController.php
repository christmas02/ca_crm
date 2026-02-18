<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load('role');

        $data = [];

        if ($user->isAdmin() || $user->isLead()) {
            $query = Opportunity::query();

            // Lead sees only their team
            if ($user->isLead()) {
                $query->where('team_id', $user->team_id);
            }

            $data['totalOpportunities'] = (clone $query)->count();
            $data['statusCounts'] = Status::withCount(['opportunities' => function ($q) use ($user) {
                if ($user->isLead()) {
                    $q->where('team_id', $user->team_id);
                }
            }])->orderBy('order')->get();
            $data['recentOpportunities'] = (clone $query)
                ->with(['client', 'status', 'assignee', 'creator'])
                ->latest()
                ->take(10)
                ->get();
            $data['totalClients'] = Client::count();
            $data['totalUsers'] = $user->isAdmin() ? User::count() : User::where('team_id', $user->team_id)->count();
        }

        if ($user->isAgentConseil()) {
            $data['assignedOpportunities'] = Opportunity::where('assigned_to', $user->id)
                ->with(['client', 'status'])
                ->latest()
                ->get();
            $data['statusCounts'] = Status::withCount(['opportunities' => function ($q) use ($user) {
                $q->where('assigned_to', $user->id);
            }])->orderBy('order')->get();
        }

        if ($user->isAgentTerrain()) {
            $data['createdOpportunities'] = Opportunity::where('created_by', $user->id)
                ->with(['client', 'status', 'assignee'])
                ->latest()
                ->get();
            $data['statusCounts'] = Status::withCount(['opportunities' => function ($q) use ($user) {
                $q->where('created_by', $user->id);
            }])->orderBy('order')->get();
        }

        return view('dashboard', $data);
    }
}
