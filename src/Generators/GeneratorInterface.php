<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Generators;

interface GeneratorInterface
{
    public function generate(string $entityName): string;
}
