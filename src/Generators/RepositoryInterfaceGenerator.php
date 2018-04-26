<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Generators;

class RepositoryInterfaceGenerator extends AbstractGenerator
{
    protected $groups = ['repository'];

    public function __construct()
    {
        $this->stub = file_get_contents(__DIR__ . '/../stubs/repository_interface.stub');
    }
}
