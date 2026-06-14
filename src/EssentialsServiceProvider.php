<?php

declare(strict_types=1);

namespace Deplox\Essentials;

use Deplox\Essentials\Console\HealthCommand;
use Deplox\Essentials\Database\Commands\DbDropCommand;
use Deplox\Essentials\Database\Commands\DbMakeCommand;
use Deplox\Essentials\Database\Commands\DbWaitCommand;
use Deplox\Essentials\Dogma\DogmaManager;
use Illuminate\Support\ServiceProvider;
use Override;

final class EssentialsServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/essentials.php', 'essentials'
        );

        $this->app->singleton(DogmaManager::class, fn ($app): DogmaManager => new DogmaManager(
            EssentialsConfig::fromArray($app->make(\Illuminate\Contracts\Config\Repository::class)->get('essentials'))
        ));
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/essentials.php' => config_path('essentials.php'),
            ], 'essentials-config');

            $this->commands([
                DbDropCommand::class,
                DbMakeCommand::class,
                DbWaitCommand::class,
                HealthCommand::class,
            ]);
        }

        $this->app->make(DogmaManager::class)->apply();
    }
}
