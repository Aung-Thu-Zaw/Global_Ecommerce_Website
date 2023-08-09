<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class FilteredByDateScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->when(request("created_from"), function ($query, $createdFrom) {
            $query->whereDate('created_at', '>=', $createdFrom);
        })
        ->when(request("created_until"), function ($query, $createdUntil) {
            $query->whereDate('created_at', '<=', $createdUntil);
        });
    }
}
