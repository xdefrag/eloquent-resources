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
{entityName : Entity name}
{--generators=all : Specify which resource to create. Available: http, repository, entity-event, entity-listener, all}
{--overwrite=false : Overwrite files}';

    protected $description = 'Generate full resource for entity';

    public function handle()
    {
        $entityName = $this->argument('entityName');
        $generators = explode(',', $this->option('generators'));
        $overwrite = $this->option('overwrite');

        $filesCreated = 0;

        /* @var GeneratorInterface $generator */
        foreach (EloquentResources::generators($generators) as $generator) {
            $context = $generator->generate($entityName);

            $namespace = PhpParser::parseNamespace($context);
            $name = PhpParser::parseName($context);

            $this->info("Generated " . $name . " in " . $namespace);

            $location = Saver::location($namespace, $name);

            Saver::save($location, $context);

            $this->info("Saved in " . $location);

            $filesCreated++;
        };

        $this->info("Generated " . $filesCreated . " files.");
    }
}
