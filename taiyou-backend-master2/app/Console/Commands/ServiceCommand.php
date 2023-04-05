<?php

namespace App\Console\Commands;
use Illuminate\Console\GeneratorCommand;

class ServiceCommand extends GeneratorCommand
{
  /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:service';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service';
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/service.stub';
    }
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Services';
    }
}

