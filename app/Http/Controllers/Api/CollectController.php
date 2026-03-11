<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CollectRequest;
use App\Http\Resources\Api\OpportunityResource;
use App\Models\Opportunity;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class CollectController extends Controller
{
    /**
     * POST /api/collect
     * Soumettre une nouvelle collecte terrain (multipart/form-data)
     * Crée une Opportunity avec statut "Nouvelle" assignée à l'agent connecté
     */
    public function store(CollectRequest $request): JsonResponse
    {
        $user = auth('sanctum')->user();

        $statusNouvelle = Status::where('name', 'Nouvelle')->firstOrFail();

        $data = [
            'created_by'             => $user->id,
            'team_id'                => $user->team_id,
            'status_id'              => $statusNouvelle->id,
            'nom'                    => $request->nom_client,
            'prenoms'                => $request->prenom_client,
            'telephone'              => $request->telephone,
            'telephone2'             => $request->telephone_secondaire,
            'observation'            => $request->observation,
            'source'                 => $request->categorie,
            'canal'                  => $request->canal,
            'isasap'                 => $request->client_asap,
            'plaque_immatriculation' => $request->immatriculation,
            'lieuprospection'        => $request->lieu_prospection,
            'assureur_actuel'        => $request->assurance_actuel,
            'echeance'               => $request->date_echeance,
            'latitude'               => $request->latitude,
            'longitude'              => $request->longitude,
            'isvisible'              => 1,
        ];

        // Upload carte grise terrain
        if ($request->hasFile('carte_grise')) {
            $data['urlcarte_grise'] = $request->file('carte_grise')
                ->store("collects/{$user->id}/carte_grise", 'public');
        }

        // Upload attestation assurance terrain
        if ($request->hasFile('attestation_assurance')) {
            $data['url_attestationassurance'] = $request->file('attestation_assurance')
                ->store("collects/{$user->id}/attestation", 'public');
        }

        $opportunity = Opportunity::create($data);
        $opportunity->load(['status', 'creator']);

        return response()->json([
            'message' => 'Collecte enregistrée avec succès.',
            'data'    => new OpportunityResource($opportunity),
        ], 201);
    }

    /**
     * GET /api/my-collects
     * Liste des collectes soumises par l'agent authentifié (ordre décroissant)
     */
    public function myCollects(): JsonResponse
    {
        $user = auth('sanctum')->user();

        $opportunities = Opportunity::where('created_by', $user->id)
            ->with('status')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'data' => OpportunityResource::collection($opportunities),
        ]);
    }
}
