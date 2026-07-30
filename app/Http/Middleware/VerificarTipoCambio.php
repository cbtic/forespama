<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\TipoCambio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class VerificarTipoCambio
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        \Log::info('Middleware ejecutado: '.$request->path());
        
        if (auth()->check()) {
            $existe = TipoCambio::whereDate('fecha', Carbon::today())->where('estado', 1)->exists();

            View::share('mostrarMensajeTipoCambio', !$existe);
        }

        return $next($request);
    }
}
