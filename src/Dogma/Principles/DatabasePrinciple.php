<?php

declare(strict_types=1);

namespace Deplox\Essentials\Dogma\Principles;

use Deplox\Essentials\EssentialsConfig;
use Illuminate\Database\Console\WipeCommand;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

final class DatabasePrinciple
{
    public static function apply(EssentialsConfig $config): void
    {
        Builder::defaultStringLength(max(0, $config->defaultStringLength));
        Builder::defaultMorphKeyType($config->defaultMorphKeyType);
        // double-gate: respects the config flag AND only enforces in production
        DB::prohibitDestructiveCommands($config->prohibitDestructiveCommands && app()->isProduction());
    }

    /** @return array<string, mixed> */
    public static function status(): array
    {
        $prohibitedProperty = (new ReflectionClass(WipeCommand::class))->getProperty('prohibitedFromRunning');

        return [
            'defaultStringLength' => Builder::$defaultStringLength,
            'defaultMorphKeyType' => Builder::$defaultMorphKeyType,
            'prohibitsDestructiveCommands' => (bool) $prohibitedProperty->getValue(),
        ];
    }
}
