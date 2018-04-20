<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Http\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface RestInterface
{
    public function all(Request $request): JsonResponse;

    public function get(Request $request): JsonResponse;

    public function create(Request $request): JsonResponse;

    public function update(Request $request): JsonResponse;

    public function destroy(Request $request): JsonResponse;
}
