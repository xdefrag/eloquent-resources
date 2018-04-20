<?php

namespace Devjs\EloquentResources\Repositories\Criterias\Common;

use Devjs\EloquentResources\Repositories\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractLimit implements CriteriaInterface
{
    protected $limit;

    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }

    public function apply(Builder $qb): Builder
    {
        return $qb->limit($this->limit);
    }
}
