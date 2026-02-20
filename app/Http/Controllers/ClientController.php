<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::withCount('opportunities');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenoms', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('plaque_immatriculation', 'like', "%{$search}%");
            });
        }

        $clients = $query->latest()->paginate(20)->withQueryString();

        return view('clients.index', compact('clients'));
    }

    public function show(Client $client)
    {
        $client->load(['opportunities.status', 'opportunities.assignee', 'opportunities.creator']);

        return view('clients.show', compact('client'));
    }
}
