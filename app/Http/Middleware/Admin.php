<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Se o usuário for admin pode prosseguir para a ação
        if($request->user()->admin) {
            return $next($request);
        }

        return response()->json('Essa ação requer permissão de administrador.', 401);
    }
}
