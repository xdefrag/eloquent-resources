<?php

namespace Devjs\EloquentResources\Repositories\Criterias\Common;

use Devjs\EloquentResources\Repositories\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractOrder implements CriteriaInterface
{
    protected $column;

    protected $order;

    public function __construct(array $params = [])
    {
        [$this->column, $this->order] = $params;
    }

    public function apply(Builder $qb): Builder
    {
        return $qb->{$this->order === 'desc' ? 'orderByDesc' : 'orderBy'}($this->column);
    }
}
