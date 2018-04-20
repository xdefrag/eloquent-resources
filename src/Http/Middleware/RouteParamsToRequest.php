<?php

namespace Devjs\EloquentResources\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RouteParamsToRequest implements Middlewarable
{
    /* @todo Works with lumen only. Needs refactoring. */
    public function handle(Request $request, Closure $next, string $guard = null)
    {
        if (isset($request->route()[2])) {
            $request->merge(
                $request->route()[2]
            );
        }

        return $next($request);
    }
}
