<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Facades;

use Symfony\Component\Finder\Finder;

class EloquentResources
{
    public static function generators(string $resource): array
    {
        $finder = new Finder();

        $finder->files()->in(__DIR__ . '/../Generators/');

        $generators = [];

        foreach ($finder as $file) {
            if (strpos($file->getFilename(), 'AbstractGenerator') !== false
                || strpos($file->getFilename(), 'GeneratorInterface') !== false
                || stripos($file->getFilename(), str_singular($resource)) === false) {
                continue;
            }

            $className = '\Devjs\EloquentResources\Generators\\'
                . str_replace('.php', '', $file->getFilename());
            $generators[] = new $className();
        }

        return $generators;
    }
}
