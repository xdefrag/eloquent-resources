<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Repositories;

use Devjs\EloquentResources\Repositories\Interfaces\HasCriteria;
use Devjs\EloquentResources\Repositories\Interfaces\HasFilter;
use Devjs\EloquentResources\Repositories\Interfaces\RepositoryInterface;
use Devjs\EloquentResources\Repositories\Traits\CriteriaTrait;
use Devjs\EloquentResources\Repositories\Traits\FilterTrait;
use Devjs\EloquentResources\Repositories\Traits\RepositoryTrait;

class AbstractRepository implements RepositoryInterface, HasCriteria, HasFilter
{
    use RepositoryTrait, CriteriaTrait, FilterTrait;

    /*
     * Eloquent model. Appointed in contructor with DI.
     */
    protected $model;

    /*
     * Additional metadata for resource.
     */
    protected $metadata;

    /*
     * Allowed methods for resource.
     */ 
    protected $allowedMethods;

    /*
     * Visible model's relations.
     */
    protected $relations = [];

    /*
     * If true = all methods will contain all appointed relations.
     */ 
    protected $allWithRelations = true;
}
