<?php

declare(strict_types=1);

namespace Deplox\Essentials\Database\Commands;

use Deplox\Essentials\Database\Actions\CreateDatabase;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait as Confirmable;
use Illuminate\Console\Prohibitable;
use Illuminate\Contracts\Console\Isolatable;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'db:make',
    description: 'Create new database',
)]
final class DbMakeCommand extends Command implements Isolatable
{
    use Confirmable;
    use Prohibitable;

    protected $signature = 'db:make {name : The database name}
                {--force : Force the operation to run when in production}';

    public function handle(CreateDatabase $createDatabase): int
    {
        if ($this->isProhibited() || ! $this->confirmToProceed()) {
            return Command::FAILURE;
        }

        $name = $this->argument('name');
        $createDatabase(is_string($name) ? $name : '');

        $this->components->info('Database created successfully.');

        return self::SUCCESS;
    }
}
