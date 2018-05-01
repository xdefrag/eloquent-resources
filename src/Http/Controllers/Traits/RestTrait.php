<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Http\Controllers\Traits;

use Devjs\EloquentResources\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait RestTrait
{
    /* @var RepositoryInterface */
    protected $repository;

    public function all(Request $request): JsonResponse
    {
        $data = [];

        if (method_exists($this, 'addMetadata')) {
            foreach ($this->addMetadata() as $key => $value) {
                $data[$key] = $value;
            }
        }

        $data['items'] = $this->repository
            ->applyCriteria()
            ->filter($request->all());

        $this->dispatchEvent($this->extractUserId($request), 0, 'all');

        return response()
            ->json($data, $status['all'] ?? Response::HTTP_OK);
    }

    public function get(Request $request): JsonResponse
    {
        $id = (int) $request->get('id');

        $item = $this->repository
            ->applyCriteria()
            ->find($id);

        $this->dispatchEvent($this->extractUserId($request), $id, 'get');

        return response()
            ->json($item, $status['get'] ?? Response::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $item = $this->repository->create($request->all());

        $this->dispatchEvent($this->extractUserId($request), $item->id, 'create');

        return response()
            ->json($item->id, $status['create'] ?? Response::HTTP_CREATED);
    }

    public function update(Request $request): JsonResponse
    {
        $item = $this->repository
            ->applyCriteria()
            ->update((int) $request->get('id'), $request->all());

        $this->dispatchEvent($this->extractUserId($request), $item->id, 'update');

        return response()
            ->json($item, $status['update'] ?? Response::HTTP_CREATED);
    }

    public function destroy(Request $request): JsonResponse
    {
        $id = (int) $request->get('id');

        $count = $this->repository
            ->applyCriteria()
            ->destroy($id);

        if (0 === $count) {
            throw new NotFoundHttpException();
        }

        $this->dispatchEvent($this->extractUserId($request), $id, 'destroy');

        return response()
            ->json(null, $status['destroy'] ?? Response::HTTP_NO_CONTENT);
    }

    protected function dispatchEvent(int $userId, int $id, string $event): void
    {
        if (!isset($this->dispatchesEvents) || !isset($this->dispatchesEvents[$event])) {
            return;
        }

        event(new $this->events[$event]($userId, $id));
    }

    protected function extractUserId(Request $request): int
    {
        return null !== $request->user() ? $request->user()->id : -1;
    }
}
