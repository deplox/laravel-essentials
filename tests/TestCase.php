<?php

declare(strict_types=1);

namespace Deplox\Essentials\Tests;

use Deplox\Essentials\EssentialsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [EssentialsServiceProvider::class];
    }
}
