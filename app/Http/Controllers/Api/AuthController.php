<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * POST /api/login
     * Connexion agent terrain — retourne un token Sanctum + infos utilisateur
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('identification', $request->identifiant)
            ->whereHas('role', fn ($q) => $q->where('slug', 'agent_terrain'))
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Identifiant ou mot de passe incorrect.',
            ], 401);
        }

        if (!$user->actif) {
            return response()->json([
                'message' => 'Compte désactivé. Contactez votre administrateur.',
            ], 403);
        }

        // Révoquer les anciens tokens pour éviter l'accumulation
        $user->tokens()->delete();

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => new UserResource($user),
        ]);
    }

    /**
     * POST /api/logout
     * Révoque le token Sanctum courant
     */
    public function logout(): JsonResponse
    {
        auth('sanctum')->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ]);
    }
}
