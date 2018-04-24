<?php

namespace Devjs\EloquentResources;

use Illuminate\Support\ServiceProvider;
use Devjs\EloquentResources\Commands\GenerateResources;

class EloquentResourcesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateResources::class,
            ]);
        }
    }

    public function register(): void
    {
        //
    }
}
