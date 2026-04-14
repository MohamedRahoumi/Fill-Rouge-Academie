<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return $this->success([], 'Utilisez POST /login pour obtenir un token Sanctum.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->error('L\'email ou le mot de passe est incorrect.', 401);
        }

        $token = $user->createToken($credentials['device_name'] ?? 'frontend')->plainTextToken;

        return $this->success([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'role' => $user->role,
            'dashboard_route' => $this->dashboardRouteByRole($user->role),
        ], 'Connexion reussie avec Sanctum.');
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $token = $user->currentAccessToken();

            if ($token) {
                $token->delete();
            } else {
                $user->tokens()->delete();
            }
        }

        return $this->success([], 'Deconnexion reussie.');
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return $this->success([
            'user' => $user,
            'role' => $user->role,
            'dashboard_route' => $this->dashboardRouteByRole($user->role),
        ]);
    }

    private function dashboardRouteByRole(string $role): string
    {
        return match($role) {
            'superadmin' => 'admin.dashboard',
            'coach'      => 'coach.dashboard',
            'parent'     => 'parent.dashboard',
            default      => 'home',
        };
    }
}
