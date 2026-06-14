<?php

declare(strict_types=1);

namespace Deplox\Essentials\Dogma\Principles;

use Deplox\Essentials\EssentialsConfig;
use Illuminate\Foundation\Vite as ViteResolver;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Sleep;
use ReflectionClass;

final class HttpPrinciple
{
    public static function apply(EssentialsConfig $config): void
    {
        // Sleep::fake and preventStrayRequests are test utilities — never apply in production.
        if (! app()->isProduction()) {
            Sleep::fake($config->fakeSleep);
            Http::preventStrayRequests($config->preventStrayRequests);
        }

        /**
         * Forces all generated URLs to use `https://`.
         * Ensures all traffic uses secure connections by default.
         */
        URL::forceHttps($config->forceHttps);

        /**
         * Configures Laravel Vite to preload assets more aggressively.
         * Improves front-end load times and user experience.
         */
        if ($config->aggressivePrefetching) {
            Vite::useAggressivePrefetching();
        }
    }

    public static function status(): array
    {
        $reflectionSleep = new ReflectionClass(Sleep::class);

        $vite = app(ViteResolver::class);
        $viteReflection = new ReflectionClass($vite);
        $prefetchStrategy = $viteReflection->getProperty('prefetchStrategy')->getValue($vite);

        return [
            'fakeSleep' => $reflectionSleep->getProperty('fake')->getValue(),
            'forceHttps' => parse_url(URL::to('/'), PHP_URL_SCHEME) === 'https',
            'aggressivePrefetching' => $prefetchStrategy === 'aggressive',
            'preventStrayRequests' => Http::preventingStrayRequests(),
        ];
    }
}
