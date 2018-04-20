<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Options
{
    /* @todo Ugly but works. Still needs refactoring */
    public function handle(Request $request, Closure $next, string $guard = null)
    {
        if ('OPTIONS' !== $request->method()) {
            return $next($request);
        }

        $filenames = scandir(base_path('app/Entities'), 0);

        $endpoint = $this->getEndpoint($request->path());

        foreach ($filenames as $filename) {
            if ($this->isNotEntityFile($filename)) {
                continue;
            }
            if ($endpoint === $this->phpFilenameToEndpoint($filename)) {
                $entity = str_replace('.php', '', $filename);
                break;
            }
        }

        if (!isset($entity)) {
            throw new NotFoundHttpException('Entity not found');
        }

        $metadata = Cache::get($this->getCacheNameMetadata($entity));
        $allowedMethods = Cache::get($this->getCacheNameAllowedMethods($entity));

        if (null === $metadata || null === $allowedMethods) {
            try {
                $repository = app('App\Repositories\\'.$entity.'Repository');
                $metadata = $repository->metadata();
                $allowedMethods = $repository->getAllowedMethods();
            } catch (\Exception $exception) {
                throw new NotAcceptableHttpException('Options for this entity not supported');
            }

            Cache::add($this->getCacheNameMetadata($entity), $metadata, 1440);
            Cache::add($this->getCacheNameAllowedMethods($entity), $allowedMethods, 1440);
        }

        return response()
            ->json($metadata)
            ->header('Access-Control-Allow-Methods', implode(', ', $allowedMethods))
            ->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'))
            ->header('Access-Control-Allow-Origin', $request->header('origin'));
    }

    private function getEndpoint(string $path): string
    {
        return preg_replace('/.+\/|"/i', '', $path);
    }

    private function isNotEntityFile(string $filename): bool
    {
        return '.' === $filename || '..' === $filename || is_dir($filename);
    }

    private function phpFilenameToEndpoint(string $filename): string
    {
        return str_plural(snake_case(str_replace('.php', '', $filename)));
    }

    private function getCacheNameMetadata(string $entity): string
    {
        return snake_case('Options'.$entity);
    }

    private function getCacheNameAllowedMethods(string $entity): string
    {
        return snake_case('Options'.$entity.'AllowedMethods');
    }
}
