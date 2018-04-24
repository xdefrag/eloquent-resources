<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Generators;

/* @todo Needs refactoring for additional placeholders */
abstract class AbstractGenerator implements GeneratorInterface
{
    protected $stub;

    public function generate(string $entityName): string
    {
        list($ns, $base) = $this->parseEntityName($entityName);

        $this->replacePlaceholders(['ns', 'base'], [$ns, $base]);

        return $this->stub;
    }

    protected function parseEntityName(string $entityName): array
    {
        $ns = '\\';
        $base = '';

        if (strpos($entityName, '\\') !== false) {
            $ns .= preg_replace('/\\\\\w+$/', '', $entityName);
            $base = preg_replace('/.+\\\\/', '', $entityName);
        } else {
            $base = $entityName;
        }

        return [$ns, $base];
    }

    protected function replacePlaceholders(array $placeholders, array $values): void
    {
        foreach ($placeholders as $key => $placeholder) {
            $this->stub = str_replace('{{' . $placeholder . '}}', $values[$key], $this->stub);
        }
    }
}
