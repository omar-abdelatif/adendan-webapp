<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeService extends GeneratorCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     */
    protected $type = 'Service';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string {
        return resource_path('stubs/service.stub');
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace($rootNamespace): string {
        return $rootNamespace . '\Services';
    }
}
