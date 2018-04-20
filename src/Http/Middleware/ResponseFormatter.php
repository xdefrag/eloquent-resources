<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResponseFormatter
{
    public function handle(Request $request, Closure $next, string $guard = null)
    {
        /* @var JsonResponse $response */
        $response = $next($request);

        $dataOriginal = json_decode($response->getContent(), true);

        $dataUpdated = [
            'apiVersion' => 'v2',
            'revision' => env('APP_COMMIT'),
            'kind' => preg_replace('/.+\\\/', '', $request->route()->getActionName()),
            'data' => $dataOriginal,
        ];

        if ($request->headers->contains('Debug', 'true') && env('APP_ENV') !== 'production') {
            $dataUpdated['_debug_backtrace'] = debug_backtrace();
            $dataUpdated['_debug_request'] = $request->all();
            $dataUpdated['_debug_current_user'] = $request->user();
        }

        $response->setContent(json_encode($dataUpdated));

        return $response;
    }
}
