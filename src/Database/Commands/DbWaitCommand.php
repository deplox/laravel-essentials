<?php

declare(strict_types=1);

namespace Deplox\Essentials\Database\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Support\Sleep;
use Symfony\Component\Console\Attribute\AsCommand;
use Throwable;

#[AsCommand(
    name: 'db:wait',
    description: 'Block until the database is reachable.',
)]
final class DbWaitCommand extends Command
{
    protected $signature = 'db:wait {--connection= : The connection name (defaults to the default connection)}
                                    {--tries=30 : Maximum number of connection attempts}
                                    {--delay=1 : Seconds to wait between attempts}';

    public function handle(ConnectionResolverInterface $resolver): int
    {
        $connectionName = $this->option('connection');
        $connection = is_string($connectionName) ? $connectionName : null;
        $tries = max(1, (int) $this->option('tries'));
        $delay = max(0, (int) $this->option('delay'));

        for ($attempt = 1; $attempt <= $tries; $attempt++) {
            try {
                $resolver->connection($connection)->select('select 1');

                $this->components->info('Database is reachable.');

                return self::SUCCESS;
            } catch (Throwable $e) {
                if ($attempt === $tries) {
                    $this->components->error('Database is unreachable: '.$e->getMessage());

                    return self::FAILURE;
                }

                $this->components->warn(sprintf(
                    'Database not reachable (attempt %d/%d) — retrying in %ds.',
                    $attempt,
                    $tries,
                    $delay,
                ));

                if ($delay > 0) {
                    Sleep::for($delay)->seconds();
                }
            }
        }

        return self::FAILURE;
    }
}
