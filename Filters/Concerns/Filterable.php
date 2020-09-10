<?php

namespace App\Filters\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
    * Define the head of the filter pipeline.
    *
    * @param Builder $builder
    * @param array   $properties
    * @param array   $filters
    *
    * @return Builder
    */
    public function scopeFilter(Builder $builder, array $properties = [], array $filters = [])
    {
        $append = 'Filters';

        $name = class_basename($this);

        $class = "App\\$append\\$name{$append}";

        return (new $class($properties))->add($filters)->filter($builder);
    }
}
