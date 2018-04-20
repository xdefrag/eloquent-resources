<?php

namespace Devjs\EloquentResources\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface HasFilter
{
    public function filter(array $parameters): Collection;
}
