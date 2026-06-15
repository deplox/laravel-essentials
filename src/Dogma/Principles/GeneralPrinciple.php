<?php

declare(strict_types=1);

namespace Deplox\Essentials\Dogma\Principles;

use Carbon\CarbonImmutable;
use Deplox\Essentials\EssentialsConfig;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rules\Password;

final class GeneralPrinciple
{
    public static function apply(EssentialsConfig $config): void
    {
        if ($config->immutableDates) {
            Date::use(CarbonImmutable::class);
        }

        if ($config->setDefaultPasswords) {
            Password::defaults(function () use ($config): Password {
                $rule = Password::min(8)->max($config->defaultStringLength);

                return app()->isProduction()
                    ? $rule->mixedCase()->uncompromised()
                    : $rule;
            });
        }
    }

    /** @return array<string, mixed> */
    public static function status(): array
    {
        return [
            'immutableDates' => ! Date::isMutable(),
            'defaultPasswordRules' => is_callable(Password::$defaultCallback),
        ];
    }
}
