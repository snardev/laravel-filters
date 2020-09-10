<?php

namespace App\Filters\Ordering;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class CreatedOrder extends FilterAbstract
{
    /**
    * Resolve the actual filter.
    *
    * @param Builder $builder
    * @param string|array  $value
    *
    * @return Builder
    */
    public function filter(Builder $builder, $value)
    {
        if (($direction = $this->resolveOrderDirection($value)) == null) {
            return $builder;
        }

        $builder->orderBy('created_at', $direction);

        return $builder;
    }
}
