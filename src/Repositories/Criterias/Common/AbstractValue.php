<?php

namespace Devjs\EloquentResources\Repositories\Criterias\Common;

use Devjs\EloquentResources\Repositories\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractValue implements CriteriaInterface
{
    private $queries;

    public function __construct(array $queries = [])
    {
        if (isset($queries[0]) && !is_array($queries[0])) {
            $queries = [$queries];
        }

        $this->queries = $queries;
    }

    public function apply(Builder $qb): Builder
    {
        foreach ($this->queries as [$column, $value]) {
            $qb = $qb->where($column, $value);
        }

        return $qb;
    }
}
