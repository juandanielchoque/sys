<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdministradorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->tipo_usuario == 'administrador') {
            return $next($request);
        }
        if ($request->user()->tipo_usuario == 'cliente') {
            return redirect()->route("homeCliente");
        }
        return redirect()->route("home");
    }
}
