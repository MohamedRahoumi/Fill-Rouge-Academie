<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return response()->json([
                'ok' => false,
                'message' => 'Non authentifie.',
            ], 401);
        }

        $user = auth()->user();

        if (!in_array($user->role, $roles)) {
            abort(403, 'Accès interdit. Vous n\'avez pas les droits nécessaires.');
        }

        return $next($request);
    }
}
