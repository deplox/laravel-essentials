<?php

declare(strict_types=1);

use Deplox\Essentials\Database\Actions\CreateDatabase;
use Deplox\Essentials\Database\Actions\DeleteDatabase;

function tempDbPath(): string
{
    return sys_get_temp_dir().'/essentials_test_'.uniqid().'.sqlite';
}

test('CreateDatabase creates a new SQLite database file', function (): void {
    $path = tempDbPath();

    app(CreateDatabase::class)($path);

    expect(file_exists($path))->toBeTrue();

    @unlink($path);
});

test('DeleteDatabase removes an existing SQLite database file', function (): void {
    $path = tempDbPath();
    touch($path);

    app(DeleteDatabase::class)($path);

    expect(file_exists($path))->toBeFalse();
});

test('DeleteDatabase is a no-op when the file does not exist', function (): void {
    $path = tempDbPath();

    expect(fn () => app(DeleteDatabase::class)($path))->not->toThrow(Throwable::class);
});
