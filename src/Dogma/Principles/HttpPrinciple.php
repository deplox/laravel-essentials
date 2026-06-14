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
        // test utilities — never apply in production even when config requests it
        if (! app()->isProduction()) {
            Sleep::fake($config->fakeSleep);
            Http::preventStrayRequests($config->preventStrayRequests);
        }

        URL::forceHttps($config->forceHttps);

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
