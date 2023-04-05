<?php

namespace App\Console\Commands;
use Illuminate\Console\GeneratorCommand;

class TransformerCommand extends GeneratorCommand
{
  /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:transformer';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new transformer';
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/transformer.stub';
    }
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Transformers';
    }
}