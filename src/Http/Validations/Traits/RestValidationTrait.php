<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Http\Validations\V2\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

trait RestValidationTrait
{
    public function all(Request $request): JsonResponse
    {
        $user = $request->user();

        if (isset($this->permissions, $this->permissions['all'])
            && !$user->hasPermissionTo($this->permissions['all'])
        ) {
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

        if (isset($this->permissions, $this->permissions['get'])
            && !$user->hasPermissionTo($this->permissions['get'])
        ) {
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

        if (isset($this->permissions, $this->permissions['create'])
            && !$user->hasPermissionTo($this->permissions['create'])
        ) {
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

        if (isset($this->permissions, $this->permissions['update'])
            && !$user->hasPermissionTo($this->permissions['update'])
        ) {
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

        if (isset($this->permissions, $this->permissions['delete'])
            && !$user->hasPermissionTo($this->permissions['delete'])
        ) {
            throw new AccessDeniedHttpException();
        }

        if (isset($this->custom, $this->custom['delete'])
            && !$this->custom['delete']($request)
        ) {
            throw new AccessDeniedHttpException();
        }

        return $this->controller->destroy($request);
    }
}
