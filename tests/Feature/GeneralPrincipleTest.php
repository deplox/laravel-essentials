<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Deplox\Essentials\Dogma\Principles\GeneralPrinciple;
use Deplox\Essentials\EssentialsConfig;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rules\Password;

function generalConfig(array $overrides = []): EssentialsConfig
{
    return EssentialsConfig::fromArray(array_merge([
        'fake_sleep' => false,
        'prevent_stray_requests' => false,
        'force_https' => false,
        'aggressive_prefetching' => false,
        'immutable_dates' => true,
        'unguard_model' => false,
        'strict_model' => false,
        'automatic_eager_load_relationships' => false,
        'require_morph_map' => false,
        'prohibit_destructive_commands' => false,
        'set_default_passwords' => true,
        'default_string_length' => 255,
        'default_morph_key_type' => 'int',
    ], $overrides));
}

test('apply sets CarbonImmutable as the date class', function (): void {
    Date::use(\Carbon\Carbon::class);

    GeneralPrinciple::apply(generalConfig(['immutable_dates' => true]));

    expect(Date::now())->toBeInstanceOf(CarbonImmutable::class);
});

test('apply skips immutable dates when disabled', function (): void {
    Date::use(\Carbon\Carbon::class);

    GeneralPrinciple::apply(generalConfig(['immutable_dates' => false]));

    expect(Date::isMutable())->toBeTrue();
});

test('apply registers a default password rule', function (): void {
    Password::$defaultCallback = null;

    GeneralPrinciple::apply(generalConfig(['set_default_passwords' => true]));

    expect(Password::$defaultCallback)->toBeCallable();
});

test('apply skips password defaults when disabled', function (): void {
    Password::$defaultCallback = null;

    GeneralPrinciple::apply(generalConfig(['set_default_passwords' => false]));

    expect(Password::$defaultCallback)->toBeNull();
});

test('status reports immutableDates as false when dates are mutable', function (): void {
    Date::use(\Carbon\Carbon::class);

    expect(GeneralPrinciple::status()['immutableDates'])->toBeFalse();
});

test('status reports immutableDates as true after apply', function (): void {
    GeneralPrinciple::apply(generalConfig(['immutable_dates' => true]));

    expect(GeneralPrinciple::status()['immutableDates'])->toBeTrue();
});

test('status reports defaultPasswordRules as true after apply', function (): void {
    GeneralPrinciple::apply(generalConfig(['set_default_passwords' => true]));

    expect(GeneralPrinciple::status()['defaultPasswordRules'])->toBeTrue();
});

test('status has expected keys', function (): void {
    $status = GeneralPrinciple::status();

    expect($status)->toHaveKeys(['immutableDates', 'defaultPasswordRules']);
});
