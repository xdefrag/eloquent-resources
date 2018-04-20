<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Http\Validations;

use Devjs\EloquentResources\Http\Interfaces\RestInterface;

class AbstractValidation implements RestInterface 
{
    /*
     * Decorated controller.
     */ 
    protected $controller;

    /*
     * Current user must have this permission to get resource action.
     */ 
    protected $permissions = [
        'all' => null,
        'get' => null,
        'create' => null,
        'update' => null,
        'destroy' => null,
    ];

    /*
     * Custom checks. If method returns true = check passed.
     * For checking belongings please use Criteria in Controller.
     */
    protected $custom = [
        'all' => null,
        'get' => null,
        'create' => null,
        'update' => null,
        'destroy' => null,
    ];

    /*
     * Rules for create and update requests.
     */ 
    protected $rules = [];
}
