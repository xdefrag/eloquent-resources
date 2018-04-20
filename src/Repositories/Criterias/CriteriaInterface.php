<?php

namespace Devjs\EloquentResources\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;

interface CriteriaInterface
{
    public function apply(Builder $qb): Builder;
}
