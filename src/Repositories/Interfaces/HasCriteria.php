<?php

namespace Devjs\EloquentResources\Repositories\Interfaces;

use Devjs\EloquentResources\Repositories\Criterias\CriteriaInterface as Criteria;

interface HasCriteria
{
    public function pushCriteria(Criteria $criteria): void;

    public function applyCriteria(): RepositoryInterface;
}
