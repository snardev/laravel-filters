<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class FilterAbstract
{
    /**
     * Resolve the actual filter.
     *
     * @param Builder      $builder
     * @param string|array $value
     *
     * @return Builder
     */
    abstract public function filter(Builder $builder, $value);

    /**
     * Mapping default method in case the taget filter class doesnt have it.
     *
     * @return array An empty array
     */
    public function mappings()
    {
        return [];
    }

    /**
     * Resolver the value to filter.
     *
     * @param string $key
     *
     * @return string
     */
    protected function resolveFilterValue(string $key)
    {
        return Arr::get($this->mappings(), $key);
    }

    /**
     * Resolve the filter list.
     *
     * @param array $list
     *
     * @return Collection
     */
    protected function resolveFilterList(array $list = [])
    {
        return collect($list)->map(function (string $value) {
            return Arr::get($this->mappings(), $value);
        });
    }

    /**
     * Resolve order direction.
     *
     * @param string $direction
     *
     * @return string
     */
    protected function resolveOrderDirection(string $direction)
    {
        $mappings = [
            'desc' => 'desc',
            'asc' => 'asc',
        ];

        return Arr::get($mappings, $direction);
    }
}
