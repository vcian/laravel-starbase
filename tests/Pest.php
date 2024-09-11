<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(
    Tests\TestCase::class,
    // Illuminate\Foundation\Testing\RefreshDatabase::class,
)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function someFunction()
{
    // ..
}

/**
 * Returns an array of model trait namespaces.
 * @return array
 */

function getModelTraitNamespaces(): array
{
    static $cachedTraitNamespaces = [];

    if ($cachedTraitNamespaces === []) {
        $baseDir = __DIR__ . '/../app';
        $traitTypes = ['Relationship', 'Scope'];
        $traitNamespaces = [];

        foreach ($traitTypes as $traitType) {
            $pattern = $baseDir . '/Models/*/Traits/' . $traitType . '/*.php';
            $files = glob($pattern);
            foreach ($files as $file) {
                $content = file_get_contents($file);
                if (preg_match('/namespace\s+([^;]+)/i', $content, $matches)) {
                    $traitNamespaces[$traitType][] = $matches[1];
                }
            }
        }

        $cachedTraitNamespaces = array_merge(
            ['flatten' => collect($traitNamespaces)->flatten()->toArray()],
            $traitNamespaces
            );
    }

    return $cachedTraitNamespaces;
}

/**
 * Returns an array of controller namespaces.
 * @return array
 */
function getControllerNamespaces(): array
{
    static $cachedControllerNamespaces = [];

    if ($cachedControllerNamespaces === []) {
        $baseDir = __DIR__ . '/../app';
        $controllerNamespaces = [];


            $pattern = $baseDir . '/Http/Controllers/*/*.php';
            $files = glob($pattern);

            foreach ($files as $file) {
                $content = file_get_contents($file);
                if (preg_match('/namespace\s+([^;]+)/i', $content, $matches)) {
                    $controllerNamespaces[] = $matches[1];
                }
            }


        $cachedControllerNamespaces = collect($controllerNamespaces)->flatten()->toArray();
    }

    return $cachedControllerNamespaces;
}

function getServicesNamespaces(): array
{
    static $cachedServicesNamespaces = [];

    if ($cachedServicesNamespaces === []) {
        $baseDir = __DIR__ . '/../app';
        $servicesNamespaces = [];


        $pattern = $baseDir . '/Services/*/*.php';
        $files = glob($pattern);

        foreach ($files as $file) {
            $content = file_get_contents($file);
            if (preg_match('/namespace\s+([^;]+)/i', $content, $matches)) {
                $servicesNamespaces[] = $matches[1];
            }
        }


        $cachedServicesNamespaces = collect($servicesNamespaces)->flatten()->toArray();
    }

    return $cachedServicesNamespaces;
}


