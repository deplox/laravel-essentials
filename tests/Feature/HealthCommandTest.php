<?php

declare(strict_types=1);

use Deplox\Essentials\Console\HealthCommand;
use Illuminate\Console\Command;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Queue\QueueManager;

test('exits SUCCESS when database, cache, and queue are healthy', function (): void {
    $this->artisan(HealthCommand::class)->assertExitCode(Command::SUCCESS);
});

test('exits FAILURE when the database throws', function (): void {
    $resolver = Mockery::mock(ConnectionResolverInterface::class);
    $resolver->allows('connection')->andThrow(new RuntimeException('Connection refused'));

    $this->app->instance(ConnectionResolverInterface::class, $resolver);

    $this->artisan(HealthCommand::class)->assertExitCode(Command::FAILURE);
});

test('exits FAILURE when the cache check fails', function (): void {
    $cache = Mockery::mock(CacheRepository::class);
    $cache->allows('put');
    $cache->allows('get')->andReturn('wrong-value');

    $this->app->instance(CacheRepository::class, $cache);

    $this->artisan(HealthCommand::class)->assertExitCode(Command::FAILURE);
});

test('exits FAILURE when the queue throws', function (): void {
    $queue = Mockery::mock(QueueManager::class);
    $queue->allows('connection')->andThrow(new RuntimeException('Queue unavailable'));

    $this->app->instance(QueueManager::class, $queue);

    $this->artisan(HealthCommand::class)->assertExitCode(Command::FAILURE);
});

test('reports each passing check as ok', function (): void {
    $this->artisan(HealthCommand::class)
        ->expectsOutputToContain('database: ok')
        ->expectsOutputToContain('cache: ok')
        ->expectsOutputToContain('queue: ok')
        ->assertExitCode(Command::SUCCESS);
});

test('reports a failing check with an error line', function (): void {
    $resolver = Mockery::mock(ConnectionResolverInterface::class);
    $resolver->allows('connection')->andThrow(new RuntimeException('refused'));

    $this->app->instance(ConnectionResolverInterface::class, $resolver);

    $this->artisan(HealthCommand::class)
        ->expectsOutputToContain('database: refused')
        ->assertExitCode(Command::FAILURE);
});

test('continues checking remaining services after one fails', function (): void {
    $resolver = Mockery::mock(ConnectionResolverInterface::class);
    $resolver->allows('connection')->andThrow(new RuntimeException('refused'));

    $this->app->instance(ConnectionResolverInterface::class, $resolver);

    $this->artisan(HealthCommand::class)
        ->expectsOutputToContain('cache: ok')
        ->expectsOutputToContain('queue: ok')
        ->assertExitCode(Command::FAILURE);
});

test('signature exposes the expected command name', function (): void {
    $command = new HealthCommand;

    expect($command->getName())->toBe('health')
        ->and($command->getDescription())->toBe('Composite health check (database, cache, queue).');
});
