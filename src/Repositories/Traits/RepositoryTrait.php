<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Repositories\Traits;

use Devjs\EloquentResources\Repositories\Tools\Metadata;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait RepositoryTrait
{
    /** @var Model $model */
    protected $model;

    public function metadata(): array
    {
        if (!property_exists($this->model, 'rules')) {
            return [];
        }

        $metadata = [];

        $metadata['entity'] = (new Metadata())($this->model::$rules);

        if (isset($this->metadata)) {
            foreach ($this->metadata as $key => $value) {
                $metadata[$key] = $value;
            }
        }

        return $metadata;
    }

    public function getAllowedMethods(): array
    {
        if (isset($this->allowedMethods)) {
            return $this->allowedMethods;
        }

        return [
            'GET',
            'POST',
            'PUT',
            'DELETE',
        ];
    }

    public function all(): Collection
    {
        $query = $this->model;

        if (isset($this->allWithRelations)
            && $this->allWithRelations
            && isset($this->relations)) {
            $query = $query->with($this->relations);
        }

        return $query->get();
    }

    public function find(int $id): Model
    {
        $query = $this->model;

        if (isset($this->relations) && !empty($this->relations)) {
            $query = $query->with($this->relations);
        }

        return $query->findOrFail($id);
    }

    public function findBy(array $params): Collection
    {
        $query = $this->model;

        foreach ($params as $key => $param) {
            if (isset($param[1]) && is_array($param[1])) {
                $query = $query->whereIn($param[0], $param[1]);
                unset($params[$key]);
            }
        }

        if (isset($this->relations) && !empty($this->relations)) {
            $query = $query->with($this->relations);
        }

        return $query->where($params)->get();
    }

    public function create(array $data): Model
    {
        /** @var Model $model */
        $model = new $this->model();
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function update(int $id, array $data): Model
    {
        $model = $this->model->findOrFail($id);
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function destroy(int $id): int
    {
        return $this->model->where('id', $id)->delete();
    }
}
