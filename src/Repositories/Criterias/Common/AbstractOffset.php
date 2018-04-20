<?php

namespace Devjs\EloquentResources\Repositories\Criterias\Common;

use Devjs\EloquentResources\Repositories\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractOffset implements CriteriaInterface
{
    protected $offset;

    public function __construct(int $offset)
    {
        $this->offset = $offset;
    }

    public function apply(Builder $qb): Builder
    {
        return $qb->offset($this->offset);
    }
}
