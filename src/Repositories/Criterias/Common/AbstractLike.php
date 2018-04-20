<?php

namespace Devjs\EloquentResources\Repositories\Criterias\Common;

use Devjs\EloquentResources\Repositories\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractLike implements CriteriaInterface
{
    protected $column;

    private $name;

    public function __construct(string $name = '')
    {
        $this->name = $name;
    }

    public function apply(Builder $qb): Builder
    {
        return $qb->where($this->column, $this->getLike(), '%' . $this->name . '%');
    }

    private function getLike(): string
    {
        return config('database.default') === 'pgsql' ? 'ilike' : 'like';
    }
}
