<?php

declare(strict_types=1);

use Deplox\Essentials\Console\HealthCommand;
use Deplox\Essentials\Database\Commands\DbDropCommand;
use Deplox\Essentials\Database\Commands\DbMakeCommand;
use Deplox\Essentials\Database\Commands\DbWaitCommand;
use Deplox\Essentials\Dogma\DogmaManager;

test('essentials config is merged on register', function (): void {
    expect(config('essentials'))->toBeArray()
        ->and(config('essentials.fake_sleep'))->toBeBool()
        ->and(config('essentials.prohibit_destructive_commands'))->toBeBool();
});

test('all artisan commands are registered', function (): void {
    $all = $this->app->make(\Illuminate\Contracts\Console\Kernel::class)->all();

    expect($all)->toHaveKey('db:make')
        ->toHaveKey('db:drop')
        ->toHaveKey('db:wait')
        ->toHaveKey('health');
});

test('registered commands are the expected classes', function (): void {
    $all = $this->app->make(\Illuminate\Contracts\Console\Kernel::class)->all();

    expect($all['db:make'])->toBeInstanceOf(DbMakeCommand::class)
        ->and($all['db:drop'])->toBeInstanceOf(DbDropCommand::class)
        ->and($all['db:wait'])->toBeInstanceOf(DbWaitCommand::class)
        ->and($all['health'])->toBeInstanceOf(HealthCommand::class);
});

test('DogmaManager is resolvable from the container', function (): void {
    expect($this->app->make(DogmaManager::class))->toBeInstanceOf(DogmaManager::class);
});

test('DogmaManager is a singleton', function (): void {
    expect($this->app->make(DogmaManager::class))
        ->toBe($this->app->make(DogmaManager::class));
});

test('DogmaManager status reflects the live configuration', function (): void {
    $status = $this->app->make(DogmaManager::class)->status();

    expect($status)->toHaveKeys(['http', 'model', 'database', 'general']);
});
