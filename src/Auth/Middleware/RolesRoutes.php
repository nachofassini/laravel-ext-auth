<?php

namespace NachoFassini\Auth\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Zizaco\Entrust\EntrustFacade as Entrust;

class RolesRoutes
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
        $routeRules = config('routes-rules');

        Log::debug('Ruta encontrada', ['ruta' => $request->path()]);

        foreach ($routeRules as $rule) {
            if ($request->is($rule['route'])) {
                if (!Entrust::can($rule['permission'])) {
                    abort(403);
                }
                return $next($request);
            }
        }

        Log::debug('No mach en ruta');
        return $next($request);
    }
}
