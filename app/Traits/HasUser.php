<?php

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait HasUser
{
    public function scopeOwned(Builder $query): Builder
    {
        return $query->where('user_id', Auth::id());
    }
}
