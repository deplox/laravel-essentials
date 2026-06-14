<?php

declare(strict_types=1);

namespace Deplox\Essentials\Dogma\Principles;

use Deplox\Essentials\EssentialsConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

final class ModelPrinciple
{
    public static function apply(EssentialsConfig $config): void
    {
        Model::unguard($config->unguardModel);
        Model::shouldBeStrict($config->strictModel);
        Model::automaticallyEagerLoadRelationships($config->automaticEagerLoadRelationships);
        // prevents raw class names from leaking into the database via polymorphic relations
        Relation::requireMorphMap($config->requireMorphMap);
    }

    public static function status(): array
    {
        return [
            'unguarded' => Model::isUnguarded(),
            'preventsLazyLoading' => Model::preventsLazyLoading(),
            'preventsSilentlyDiscardingAttributes' => Model::preventsSilentlyDiscardingAttributes(),
            'preventsAccessingMissingAttributes' => Model::preventsAccessingMissingAttributes(),
            'automaticallyEagerLoadRelationships' => Model::isAutomaticallyEagerLoadingRelationships(),
            'requireMorphMap' => Relation::requiresMorphMap(),
        ];
    }
}
