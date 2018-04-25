<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Commands;

use Devjs\EloquentResources\Facades\EloquentResources;
use Devjs\EloquentResources\Facades\PhpParser;
use Devjs\EloquentResources\Facades\Saver;
use Devjs\EloquentResources\Generators\GeneratorInterface;
use Illuminate\Console\Command;

class GenerateResources extends Command
{
    protected $signature = 'eloquent-resources:generate
{entityName : Entity name}';

    protected $description = 'Generate full resource for entity';

    public function handle()
    {
        $entityName = $this->argument('entityName');

        /* @var GeneratorInterface $generator */
        foreach (EloquentResources::generators() as $generator) {
            $context = $generator->generate($entityName);

            $namespace = PhpParser::parseNamespace($context);
            $name = PhpParser::parseName($context);

            $this->info("Generated " . $name . " in " . $namespace);

            $location = Saver::location($namespace, $name);
            
            Saver::save($location, $context);

            $this->info("Saved in " . $location);
        };

        $this->info("All files generated.");
    }
}
