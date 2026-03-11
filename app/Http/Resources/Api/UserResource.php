<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'nom'         => $this->name,
            'identifiant' => $this->identification,
            'zone'        => $this->team?->name,
        ];
    }
}
