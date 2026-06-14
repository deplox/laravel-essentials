<?php

declare(strict_types=1);

use Deplox\Essentials\Console\HealthCommand;
use Illuminate\Console\Command;
use Illuminate\Database\ConnectionResolverInterface;

test('exits SUCCESS when database, cache, and queue are healthy', function (): void {
    $this->artisan(HealthCommand::class)->assertExitCode(Command::SUCCESS);
});

test('exits FAILURE when the database throws', function (): void {
    $resolver = Mockery::mock(ConnectionResolverInterface::class);
    $resolver->allows('connection')->andThrow(new RuntimeException('Connection refused'));

    $this->app->instance(ConnectionResolverInterface::class, $resolver);

    $this->artisan(HealthCommand::class)->assertExitCode(Command::FAILURE);
});

test('signature exposes the expected command name', function (): void {
    $command = new HealthCommand;

    expect($command->getName())->toBe('health')
        ->and($command->getDescription())->toBe('Composite health check (database, cache, queue).');
});
