<?php

namespace Devjs\EloquentResources\Repositories\Traits;

use Illuminate\Database\Eloquent\Collection;

trait FilterTrait
{
    public function filter(array $parameters): Collection
    {
        $criteriaNamespace = 'App\Repositories\Criterias\\' . class_basename($this->model)  . '\\';

        foreach ($parameters as $filter => $data) {
            $criteriaClassPath = $criteriaNamespace . studly_case($filter);

            if (!class_exists($criteriaClassPath)) {
                continue;
            }

            $criteria = new $criteriaClassPath($data);

            $this->pushCriteria($criteria);
        }

        return $this->applyCriteria()->all();
    }
}
