<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Http\Validations\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

trait RestValidationTrait
{
    public function all(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$this->isUserHasPermissionTo($user, 'all')) {
            throw new AccessDeniedHttpException();
        }

        if (isset($this->custom, $this->custom['all'])
            && !$this->custom['all']($request)
        ) {
            throw new AccessDeniedHttpException();
        }

        return $this->controller->all($request);
    }

    public function get(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$this->isUserHasPermissionTo($user, 'get')) {
            throw new AccessDeniedHttpException();
        }

        if (isset($this->custom, $this->custom['get'])
            && !$this->custom['get']($request)
        ) {
            throw new AccessDeniedHttpException();
        }

        return $this->controller->get($request);
    }

    public function create(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if (!$this->isUserHasPermissionTo($user, 'create')) {
            throw new AccessDeniedHttpException();
        }

        if (isset($this->custom, $this->custom['create'])
            && !$this->custom['create']($request)
        ) {
            throw new AccessDeniedHttpException();
        }

        if (isset($this->rules)) {
            $this->validate($request, $this->rules);
        }

        return $this->controller->create($request);
    }

    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$this->isUserHasPermissionTo($user, 'update')) {
            throw new AccessDeniedHttpException();
        }

        if (isset($this->custom, $this->custom['update'])
            && !$this->custom['update']($request)
        ) {
            throw new AccessDeniedHttpException();
        }

        if (isset($this->rules)) {
            $this->validate($request, $this->rules);
        }

        return $this->controller->update($request);
    }

    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$this->isUserHasPermissionTo($user, 'destroy')) {
            throw new AccessDeniedHttpException();
        }

        if (isset($this->custom, $this->custom['destroy'])
            && !$this->custom['destroy']($request)
        ) {
            throw new AccessDeniedHttpException();
        }

        return $this->controller->destroy($request);
    }

    protected function isUserHasPermissionTo(?Model $user, string $method): bool
    {
        return (isset($this->permissions, $this->permissions['all']) && $user === null)
            || ($user !== null && $user->hasPermissionTo($this->permissions['all']));
    }
}
