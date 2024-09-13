<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

final class MakeFeatureScaffoldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:feature-scaffold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a feature scaffold for a model';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $modelName = $this->ask('What is the name of the model?');
        $modelName = Str::studly($modelName);

        $this->createModel($modelName);
        $this->createRelationships($modelName);
        $this->createScopes($modelName);
        $this->createService($modelName);
        $this->createController($modelName);

        $this->info("Feature scaffold for {$modelName} created successfully!");

        return Command::SUCCESS;
    }

    protected function createModel(string $modelName): void
    {
        $stubPath = $this->laravel->basePath('stubs/model.stub');
        $modelPath = app_path("Models/{$modelName}/{$modelName}.php");

        if (!File::exists($stubPath)) {
            $this->error('Model stub not found. Please create it first.');
            return;
        }

        $stubContent = File::get($stubPath);
        $modelContent = Str::replace(
            ['{{ namespace }}', '{{ class }}'],
            ["App\\Models\\{$modelName}", $modelName],
            $stubContent
        );

        File::ensureDirectoryExists(dirname($modelPath));
        File::put($modelPath, $modelContent);

        $this->info("Model created: {$modelPath}");
    }

    protected function createRelationships(string $modelName): void
    {
        if ($this->confirm('Do you want to create relationships?')) {
            $relationshipName = $this->ask('Enter the relationship name:');
            $relationshipPath = app_path("Models/{$modelName}/Traits/Relationships/{$relationshipName}.php");

            $stubContent = File::get($this->laravel->basePath('stubs/relationship.stub'));
            $content = Str::replace(
                ['{{ namespace }}', '{{ class }}', '{{ relationshipName }}'],
                ["App\\Models\\{$modelName}\\Traits\\Relationships", $modelName, $relationshipName],
                $stubContent
            );

            File::ensureDirectoryExists(dirname($relationshipPath));
            File::put($relationshipPath, $content);

            $this->info("Relationship created: {$relationshipPath}");
        }
    }

    protected function createScopes(string $modelName): void
    {
        if ($this->confirm('Do you want to create scopes?')) {
            $scopeName = $this->ask('Enter the scope name:');
            $scopePath = app_path("Models/{$modelName}/Traits/Scopes/{$scopeName}.php");

            $stubContent = File::get($this->laravel->basePath('stubs/scope.stub'));
            $content = Str::replace(
                ['{{ namespace }}', '{{ class }}', '{{ scopeName }}'],
                ["App\\Models\\{$modelName}\\Traits\\Scopes", $modelName, $scopeName],
                $stubContent
            );

            File::ensureDirectoryExists(dirname($scopePath));
            File::put($scopePath, $content);

            $this->info("Scope created: {$scopePath}");
        }
    }

    protected function createService(string $modelName): void
    {
        if ($this->confirm('Do you want to create a service?')) {
            $servicePath = app_path("Services/{$modelName}/{$modelName}Service.php");

            $stubContent = File::get($this->laravel->basePath('stubs/service.stub'));
            $content = Str::replace(
                ['{{ namespace }}', '{{ class }}', '{{ model }}'],
                ["App\\Services\\{$modelName}", "{$modelName}Service", $modelName],
                $stubContent
            );

            File::ensureDirectoryExists(dirname($servicePath));
            File::put($servicePath, $content);

            $this->info("Service created: {$servicePath}");
        }
    }

    protected function createController(string $modelName): void
    {
        if ($this->confirm('Do you want to create a controller?')) {
            $controllerPath = app_path("Http/Controllers/{$modelName}/{$modelName}Controller.php");

            $stubContent = File::get($this->laravel->basePath('stubs/controller.stub'));
            $content = Str::replace(
                ['{{ namespace }}', '{{ class }}', '{{ model }}'],
                ["App\\Http\\Controllers\\{$modelName}", "{$modelName}Controller", $modelName],
                $stubContent
            );

            File::ensureDirectoryExists(dirname($controllerPath));
            File::put($controllerPath, $content);

            $this->info("Controller created: {$controllerPath}");
        }
    }
}
