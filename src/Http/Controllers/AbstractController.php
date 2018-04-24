<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Http\Controllers;

use Devjs\EloquentResources\Http\Interfaces\RestInterface;
use Devjs\EloquentResources\Http\Controllers\Traits\RestTrait;
use Illuminate\Http\Response;

abstract class AbstractController implements RestInterface
{
    use RestTrait;

    /*
     * All events recieves current user id and entity id.
     */ 
    protected $dispatchesEvents = [
        'all' => null,
        'get' => null,
        'create' => null,
        'update' => null,
        'destroy' => null,
    ];

    /*
     * Custom statuses for resource. Handy for accepted
     * methods, if it queued.
     */ 
    protected $status = [
        'all' => Response::HTTP_OK,
        'get' => Response::HTTP_OK,
        'create' => Response::HTTP_CREATED,
        'update' => Response::HTTP_CREATED,
        'destroy' => Response::HTTP_NO_CONTENT,
    ];

    /*
     * Adds metadata to 'all' request.
     */ 
    protected function addMetadata(array $data): array
    {
        return $data;
    }
}
