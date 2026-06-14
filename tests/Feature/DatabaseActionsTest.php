<?php

declare(strict_types=1);

use Deplox\Essentials\Database\Actions\CreateDatabase;
use Deplox\Essentials\Database\Actions\DeleteDatabase;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder;

function mockConnection(string $driver = 'mysql'): Connection
{
    $schema = Mockery::mock(Builder::class);
    $schema->allows('createDatabase')->byDefault();
    $schema->allows('dropDatabaseIfExists')->byDefault();

    $connection = Mockery::mock(Connection::class);
    $connection->allows('getSchemaBuilder')->andReturn($schema);
    $connection->allows('getDriverName')->andReturn($driver);

    return $connection;
}

test('CreateDatabase delegates to schema builder with the given name', function (): void {
    $connection = mockConnection();
    $connection->getSchemaBuilder()->expects('createDatabase')->with('my_db')->once();

    (new CreateDatabase($connection))('my_db');
});

test('DeleteDatabase delegates to schema builder with the given name', function (): void {
    $connection = mockConnection();
    $connection->expects('statement')->never();
    $connection->getSchemaBuilder()->expects('dropDatabaseIfExists')->with('my_db')->once();

    (new DeleteDatabase($connection))('my_db');
});

test('DeleteDatabase terminates open pgsql connections before dropping', function (): void {
    $schema = Mockery::mock(Builder::class);
    $schema->expects('dropDatabaseIfExists')->with('my_db')->once();

    $connection = Mockery::mock(Connection::class);
    $connection->allows('getSchemaBuilder')->andReturn($schema);
    $connection->allows('getDriverName')->andReturn('pgsql');
    $connection->expects('statement')
        ->withArgs(fn (string $sql, array $bindings): bool => str_contains($sql, 'pg_terminate_backend') && $bindings === ['my_db'])
        ->once();

    (new DeleteDatabase($connection))('my_db');
});

test('DeleteDatabase does not terminate connections for non-pgsql drivers', function (): void {
    foreach (['mysql', 'mariadb', 'sqlite'] as $driver) {
        $connection = mockConnection($driver);
        $connection->expects('statement')->never();
        $connection->getSchemaBuilder()->expects('dropDatabaseIfExists')->with('x')->once();

        (new DeleteDatabase($connection))('x');
    }
});
