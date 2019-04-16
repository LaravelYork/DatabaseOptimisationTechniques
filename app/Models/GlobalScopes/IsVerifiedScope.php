<?php

namespace App\Models\GlobalScopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class IsVerifiedScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('is_validated', 1);
    }
}