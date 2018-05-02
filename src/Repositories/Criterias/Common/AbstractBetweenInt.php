<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Repositories\Criterias\Common;

use Devjs\EloquentResources\Repositories\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractBetweenInt implements CriteriaInterface
{
    protected $column;
    protected $minMax;

    public function __construct(array $minMax)
    {
        $this->minMax = $minMax;
    }

    public function apply(Builder $qb): Builder
    {
        return $qb->whereBetween($this->column, $this->minMax);
    }
}
