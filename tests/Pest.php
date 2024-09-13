<?php

use Illuminate\Support\Str;

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
 * @return array|array[]
 */

function getModelTraitNamespaces(): array
{
    static $cachedResult = null;

    // If the result is already cached, return it
    if ($cachedResult !== null) {
        return $cachedResult;
    }

    // Define the directory to search
    $directory = __DIR__ . '/../app/Models';
    $traitNamespaces = [
        'relationship' => [],
        'scope' => [],
        'flatten' => []
    ];

    // Create a recursive iterator
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory)
    );

    foreach ($iterator as $file) {
        // Process only PHP files in the 'Traits' folder
        if (isPhpTraitFile($file)) {
            $namespace = extractNamespace($file->getPathname());

            if ($namespace) {
                // Add namespace to appropriate arrays
                addNamespaceToArray($traitNamespaces, $namespace, $file->getPathname());
            }
        }
    }

    // Ensure no duplicates and cache the result
    $traitNamespaces['relationship'] = array_unique($traitNamespaces['relationship']);
    $traitNamespaces['scope'] = array_unique($traitNamespaces['scope']);
    $traitNamespaces['flatten'] = array_unique($traitNamespaces['flatten']);

    return $cachedResult = $traitNamespaces;
}

/**
 * Check if the file is a PHP file in the 'Traits' folder.
 *
 * @param \SplFileInfo $file
 * @return bool
 */
function isPhpTraitFile(\SplFileInfo $file): bool
{
    return $file->isFile() && $file->getExtension() === 'php' && Str::contains($file->getPathname(), 'Traits');
}

/**
 * Extract the namespace from a PHP file.
 *
 * @param string $filePath
 * @return string|null
 */
function extractNamespace(string $filePath): ?string
{
    $content = file_get_contents($filePath);
    if (preg_match('/namespace\s+([^;]+)/i', $content, $matches)) {
        return trim($matches[1]);
    }
    return null;
}

/**
 * Add namespace to the appropriate arrays in the traitNamespaces.
 *
 * @param array $traitNamespaces
 * @param string $namespace
 * @param string $filePath
 */
function addNamespaceToArray(array &$traitNamespaces, string $namespace, string $filePath): void
{
    if (Str::contains($filePath, 'Relationship') && !in_array($namespace, $traitNamespaces['relationship'])) {
        $traitNamespaces['relationship'][] = $namespace;
    }

    if (Str::contains($filePath, 'Scope') && !in_array($namespace, $traitNamespaces['scope'])) {
        $traitNamespaces['scope'][] = $namespace;
    }

    if (!in_array($namespace, $traitNamespaces['flatten'])) {
        $traitNamespaces['flatten'][] = $namespace;
    }
}

/**
 * Returns an array of controller namespaces.
 * @return array
 */
function getControllerNamespaces(): array
{
    static $cachedControllerNamespaces = [];

    if ($cachedControllerNamespaces === []) {
        $controllerNamespaces = [];
        $files = glob(__DIR__ . '/../app/Http/Controllers/*/*.php');

        foreach ($files as $file) {
            $controllerNamespaces[] = extractNamespace($file);
        }

        $cachedControllerNamespaces = collect($controllerNamespaces)->flatten()->toArray();
    }

    return $cachedControllerNamespaces;
}

function getServicesNamespaces(): array
{
    static $cachedServicesNamespaces = [];

    if ($cachedServicesNamespaces === []) {
        $servicesNamespaces = [];
        $files = glob(__DIR__ . '/../app/Services/*/*.php');

        foreach ($files as $file) {
            $servicesNamespaces[] = extractNamespace($file);
        }

        $cachedServicesNamespaces = collect($servicesNamespaces)->flatten()->toArray();
    }

    return $cachedServicesNamespaces;
}
