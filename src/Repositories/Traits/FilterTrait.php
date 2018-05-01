<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Repositories\Traits;

use Illuminate\Database\Eloquent\Collection;

trait FilterTrait
{
    public function filter(array $parameters): Collection
    {
        $criteriaCustomNamespace = config('eloquent-resources.criteria.custom_path') . class_basename($this->model)  . '\\';

        foreach ($parameters as $filter => $data) {
            $criteriaCustomClassPath = $criteriaCustomNamespace . studly_case($filter);
            $criteriaDefaulClassPath = config('eloquent-resources.criteria.default_path') . studly_case($filter);

            if (class_exists($criteriaCustomClassPath)) {
                $this->pushCriteria(new $criteriaCustomClassPath($data));
                continue;
            }

            if (class_exists($criteriaDefaulClassPath)) {
                $this->pushCriteria(new $criteriaDefaulClassPath($data));
                continue;
            }
        }

        return $this->applyCriteria()->all();
    }
}
