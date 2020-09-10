<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class FiltersAbstract
{
    /**
     * The properties from the request.
     *
     * @var array
     */
    protected $properties = [];

    /**
     * List of filters.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Create a new instance of filter.
     *
     * @param array $properties
     */
    public function __construct(array $properties = [])
    {
        $this->setProperties($properties);
    }

    /**
     * Allow us to dynamically add filters.
     *
     * @param array $filters
     *
     * @return self
     */
    public function add(array $filters = [])
    {
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    /**
     * Filter pipeline resolver.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function filter(Builder $builder)
    {
        foreach ($this->getFilters() as $filter => $value) {
            $this->resolveFilter($filter)->filter($builder, $value);
        }

        return $builder;
    }

    /**
     * Resolve filter.
     *
     * @param string $filter
     *
     * @return FilterAbstract
     */
    protected function resolveFilter(string $filter)
    {
        return new $this->filters[$filter]();
    }

    /**
     * Get filters.
     *
     * @return array
     */
    protected function getFilters()
    {
        return $this->filterFilters();
    }

    /**
     * Filter filters.
     *
     * @return array
     */
    protected function filterFilters()
    {
        $keys = array_keys($this->filters);

        // Remove items with null values
        $filters = array_filter(Arr::only($this->properties, $keys));

        // Filters the keys that are defined
        $orderedKeys = array_filter($keys, function ($key) use ($filters) {
            return in_array($key, array_keys($filters));
        });

        // Sort by the defined order
        return array_merge(array_flip($orderedKeys), $filters);
        
    }

    /**
     * Set properties to filter.
     *
     * @param array $properties
     */
    protected function setProperties(array $properties = [])
    {
        $properties = empty($properties) ? request()->all() : $properties;

        $properties = collect($properties)
            ->flatMap(function ($value, $key) {
                $key = Str::kebab(Str::camel($key));
                $value = is_bool($value) ? \json_encode($value) : $value;

                return [$key => $value];
            })
            ->toArray();

        $this->properties = $properties;
    }
}
