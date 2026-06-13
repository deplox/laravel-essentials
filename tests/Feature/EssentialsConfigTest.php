<?php

declare(strict_types=1);

use Deplox\Essentials\EssentialsConfig;

test('fromArray uses documented defaults when array is empty', function (): void {
    $config = EssentialsConfig::fromArray([]);

    expect($config->fakeSleep)->toBeTrue()
        ->and($config->preventStrayRequests)->toBeTrue()
        ->and($config->forceHttps)->toBeTrue()
        ->and($config->aggressivePrefetching)->toBeTrue()
        ->and($config->immutableDates)->toBeTrue()
        ->and($config->unguardModel)->toBeFalse()
        ->and($config->strictModel)->toBeTrue()
        ->and($config->automaticEagerLoadRelationships)->toBeTrue()
        ->and($config->requireMorphMap)->toBeTrue()
        ->and($config->prohibitDestructiveCommands)->toBeTrue()
        ->and($config->setDefaultPasswords)->toBeTrue()
        ->and($config->defaultStringLength)->toBe(255)
        ->and($config->defaultMorphKeyType)->toBe('int');
});

test('fromArray accepts null and returns defaults', function (): void {
    $config = EssentialsConfig::fromArray(null);

    expect($config->defaultStringLength)->toBe(255)
        ->and($config->defaultMorphKeyType)->toBe('int');
});

test('fromArray respects overridden values', function (): void {
    $config = EssentialsConfig::fromArray([
        'unguard_model' => true,
        'default_string_length' => 191,
        'default_morph_key_type' => 'uuid',
        'strict_model' => false,
    ]);

    expect($config->unguardModel)->toBeTrue()
        ->and($config->defaultStringLength)->toBe(191)
        ->and($config->defaultMorphKeyType)->toBe('uuid')
        ->and($config->strictModel)->toBeFalse();
});

test('toArray round-trips through fromArray', function (): void {
    $original = EssentialsConfig::fromArray([
        'fake_sleep' => false,
        'prevent_stray_requests' => false,
        'force_https' => false,
        'aggressive_prefetching' => false,
        'immutable_dates' => false,
        'unguard_model' => true,
        'strict_model' => false,
        'automatic_eager_load_relationships' => false,
        'require_morph_map' => false,
        'prohibit_destructive_commands' => false,
        'set_default_passwords' => false,
        'default_string_length' => 100,
        'default_morph_key_type' => 'string',
    ]);

    $roundTripped = EssentialsConfig::fromArray($original->toArray());

    expect($roundTripped->toArray())->toBe($original->toArray());
});

test('toArray returns all expected keys', function (): void {
    $config = EssentialsConfig::fromArray([]);

    expect($config->toArray())->toHaveKeys([
        'fake_sleep',
        'prevent_stray_requests',
        'force_https',
        'aggressive_prefetching',
        'immutable_dates',
        'unguard_model',
        'strict_model',
        'automatic_eager_load_relationships',
        'require_morph_map',
        'prohibit_destructive_commands',
        'set_default_passwords',
        'default_string_length',
        'default_morph_key_type',
    ]);
});
