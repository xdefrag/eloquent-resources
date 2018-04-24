<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Generators;

class ControllerGenerator extends AbstractGenerator
{
    public function __construct()
    {
        $this->stub = file_get_contents(__DIR__ . '/../stubs/controller.stub');
    }
}
