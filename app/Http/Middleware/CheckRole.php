<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Maneja una solicitud entrante.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Si el usuario no está logueado o su rol no es el que pedimos
        if (!$request->user() || $request->user()->role !== $role) {
            // Lo mandamos al dashboard con un mensaje de error
            return redirect('/dashboard')->with('error', 'Acceso denegado: Se requieren permisos de ' . $role);
        }

        return $next($request);
    }
}