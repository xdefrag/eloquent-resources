<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Facades;

use Symfony\Component\Finder\Finder;

class EloquentResources
{
    public static function generators(array $only = ['all']): array
    {
        $finder = new Finder();

        $finder->files()->in(__DIR__ . '/../Generators/');

        $generators = [];

        foreach ($finder as $file) {
            if (strpos($file->getFilename(), 'AbstractGenerator') !== false
                || strpos($file->getFilename(), 'GeneratorInterface') !== false) {
                continue;
            }

            $className = '\Devjs\EloquentResources\Generators\\'
                . str_replace('.php', '', $file->getFilename());
            $generator = new $className();

            if (in_array('all', $only) || $generator->isInGroups($only)) {
                $generators[] = $generator;
            }

            unset($generator);
        }

        return $generators;
    }
}
