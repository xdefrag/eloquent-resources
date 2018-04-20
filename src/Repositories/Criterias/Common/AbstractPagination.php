<?php

namespace Devjs\EloquentResources\Repositories\Criterias\Common;

use Devjs\EloquentResources\Repositories\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractPagination implements CriteriaInterface
{
    protected $current;
    protected $per;

    public function __construct(array $pagination)
    {
        $this->current = $pagination[0];
        $this->per = $pagination[1];
    }

    public function apply(Builder $qb): Builder
    {
        return $qb
            ->skip(($this->current - 1) * $this->per)
            ->take($this->per);
    }
}
