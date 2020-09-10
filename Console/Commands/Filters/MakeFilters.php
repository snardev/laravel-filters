<?php

namespace App\Console\Commands\Filters;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeFilters extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:filters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new filters';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Filters';

    /**
     * Undocumented function.
     */
    public function getType()
    {
        return Str::plural($this->type);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $name = Str::lower($this->type);

        return __DIR__."/stubs/$name.stub";
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Filters';
    }
}
