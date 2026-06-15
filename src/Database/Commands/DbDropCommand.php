<?php

declare(strict_types=1);

namespace Deplox\Essentials\Database\Commands;

use Deplox\Essentials\Database\Actions\DeleteDatabase;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait as Confirmable;
use Illuminate\Console\Prohibitable;
use Illuminate\Contracts\Console\Isolatable;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'db:drop',
    description: 'Delete existing database',
)]
final class DbDropCommand extends Command implements Isolatable
{
    use Confirmable;
    use Prohibitable;

    protected $signature = 'db:drop {name : The database name}
                {--force : Force the operation to run when in production}';

    public function handle(DeleteDatabase $deleteDatabase): int
    {
        if ($this->isProhibited() || ! $this->confirmToProceed()) {
            return Command::FAILURE;
        }

        $name = $this->argument('name');
        $deleteDatabase(is_string($name) ? $name : '');

        $this->components->info('Database dropped successfully.');

        return self::SUCCESS;
    }
}
