<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * EmployeeSocial
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class EmployeeSocial extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
