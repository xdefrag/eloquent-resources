<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Generators;

class ListenerCreatedGenerator extends AbstractGenerator
{
    protected $groups = ['entity-listener'];

    public function __construct()
    {
        $this->stub = file_get_contents(__DIR__ . '/../stubs/listener_created.stub');
    }
}
