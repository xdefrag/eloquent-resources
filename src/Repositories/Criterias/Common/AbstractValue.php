<?php

namespace Devjs\EloquentResources\Repositories\Criterias\Common;

use Devjs\EloquentResources\Repositories\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractValue implements CriteriaInterface
{
    protected $column;

    private $value;

    public function __construct(string $value = '')
    {
        $this->value = $value;
    }

    public function apply(Builder $qb): Builder
    {
        return $qb->where($this->column, $this->value);
    }
}
