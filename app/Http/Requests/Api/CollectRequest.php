<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CollectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom_client'             => ['required', 'string', 'max:100'],
            'prenom_client'          => ['required', 'string', 'max:100'],
            'telephone'              => ['required', 'string', 'max:20'],
            'telephone_secondaire'   => ['nullable', 'string', 'max:20'],
            'observation'            => ['nullable', 'string'],
            'categorie'              => ['required', 'string', 'max:50'],
            'canal'                  => ['required', 'in:campagne,normal'],
            'client_asap'            => ['required', 'in:OUI,NON'],
            'immatriculation'        => ['required', 'string', 'max:20'],
            'lieu_prospection'       => ['required', 'string', 'max:150'],
            'assurance_actuel'       => ['required', 'string', 'max:100'],
            'date_echeance'          => ['required', 'string'],
            'latitude'               => ['nullable', 'numeric'],
            'longitude'              => ['nullable', 'numeric'],
            'carte_grise'            => ['nullable', 'file', 'image', 'max:5120'],
            'attestation_assurance'  => ['nullable', 'file', 'image', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom_client.required'         => 'Le nom du client est requis.',
            'prenom_client.required'      => 'Le prénom du client est requis.',
            'telephone.required'          => 'Le téléphone est requis.',
            'categorie.required'          => 'La catégorie est requise.',
            'canal.required'              => 'Le canal est requis.',
            'canal.in'                    => 'Le canal doit être "campagne" ou "normal".',
            'client_asap.required'        => 'Le champ Client ASAP est requis.',
            'client_asap.in'              => 'Client ASAP doit être "OUI" ou "NON".',
            'immatriculation.required'    => 'L\'immatriculation est requise.',
            'lieu_prospection.required'   => 'Le lieu de prospection est requis.',
            'assurance_actuel.required'   => 'L\'assurance actuelle est requise.',
            'date_echeance.required'      => 'La date d\'échéance est requise.',
            'carte_grise.image'           => 'La carte grise doit être une image.',
            'carte_grise.max'             => 'La carte grise ne doit pas dépasser 5 Mo.',
            'attestation_assurance.image' => 'L\'attestation doit être une image.',
            'attestation_assurance.max'   => 'L\'attestation ne doit pas dépasser 5 Mo.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Erreur de validation',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
