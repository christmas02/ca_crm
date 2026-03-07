<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OpportunityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                        => $this->id,
            'nom_client'                => $this->nom,
            'prenom_client'             => $this->prenoms,
            'telephone'                 => $this->telephone,
            'telephone_secondaire'      => $this->telephone2,
            'observation'               => $this->observation,
            'categorie'                 => $this->source,
            'canal'                     => $this->canal,
            'client_asap'               => $this->isasap,
            'immatriculation'           => $this->plaque_immatriculation,
            'lieu_prospection'          => $this->lieuprospection,
            'assurance_actuel'          => $this->assureur_actuel,
            'date_echeance'             => $this->echeance?->format('d/m/Y'),
            'latitude'                  => $this->latitude,
            'longitude'                 => $this->longitude,
            'carte_grise_url'           => $this->urlcarte_grise_terrain
                ? Storage::disk('public')->url($this->urlcarte_grise_terrain)
                : null,
            'attestation_assurance_url' => $this->url_attestationassurance_terrain
                ? Storage::disk('public')->url($this->url_attestationassurance_terrain)
                : null,
            'statut'                    => $this->whenLoaded('status', fn () => $this->status->name),
            'created_by'                => $this->created_by,
            'created_at'                => $this->created_at,
            'updated_at'                => $this->updated_at,
        ];
    }
}
