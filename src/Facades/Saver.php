<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Facades;

class Saver
{
    public static function save(string $location, string $context): void
    {
        $dir = '';
        
        foreach (explode('/', $location) as $currentDir) {
            $dir .= $currentDir . '/';
            if (!is_dir($dir) && strpos($currentDir, '.') === false) {
                mkdir($dir, 0755, true);
            }
        }

        $file = fopen($location, 'w');
        fwrite($file, $context);
        fclose($file);
    }

    public static function location(string $namespace, string $name): string
    {
        return str_replace('\\', '/',
            str_replace('App', base_path('app'), $namespace)
        ) . '/' . $name . '.php';
    }
}
