<?php

namespace Devjs\EloquentResources\Repositories\Criterias\Common;

use Devjs\EloquentResources\Repositories\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractBetweenInt implements CriteriaInterface
{
    protected $column;
    private $minMax;

    public function __construct(array $minMax)
    {
        $this->minMax = $minMax;
    }

    public function apply(Builder $qb): Builder
    {
        return $qb->whereBetween($this->column, $this->minMax);
    }
}
