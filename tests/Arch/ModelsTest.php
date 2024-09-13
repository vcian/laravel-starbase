<?php

declare(strict_types=1);

/**
 * This test suite ensures that all models in the 'App\Models' namespace adhere to specific architectural rules:
 * - Models should be final.
 * - Models should have a 'casts' method.
 * - Models should extend 'Illuminate\Database\Eloquent\Model'.
 * - Models should only be used within the specified namespaces.
 */


arch('models')
    ->expect('App\Models')
    ->toBeFinal() // Ensure that all models are final.
    ->ignoring(
        getModelTraitNamespaces()['flatten']
    )
    ->toBeClasses() // Ensure that all models are classes.
    ->ignoring( // Ignore traits.
        getModelTraitNamespaces()['flatten']
    )
    ->toHaveMethod('casts') // Ensure that all models have a 'casts' method.
    ->ignoring(getModelTraitNamespaces()['flatten'])
    ->toExtend('Illuminate\Database\Eloquent\Model') // Ensure that all models extend 'Illuminate\Database\Eloquent\Model'.
    ->ignoring(getModelTraitNamespaces()['flatten'])
    ->toUseStrictTypes()
    ->toOnlyBeUsedIn(
        [ // Ensure that all models are only used within the specified namespaces.
            'App\Models',
            'App\Http',
            'App\Services',
            'App\Providers',
            'App\Events',
            'App\Mail',
            'App\Jobs',
            'App\Listeners',
            'App\Notifications',
            'App\Policies',
            'App\Console',
            'Database\Factories'
        ]
    );

/**
 * This test suite ensure that all model  relationship traits adhere to specific architectural rules:
 */
arch('relationship')
    ->expect(getModelTraitNamespaces()['relationship'])
    ->toBeTrait()
    ->toHaveSuffix('Relationship')
    ->toUseStrictTypes();

/**
 * This test suite ensure that all model  scope traits adhere to specific architectural rules:
 */
arch('scope')
    ->expect(getModelTraitNamespaces()['scope'])
    ->toBeTrait()
    ->toHaveSuffix('Scope')
    ->toUseStrictTypes();


