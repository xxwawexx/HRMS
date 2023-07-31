<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * EmployeeWorkingHours
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class EmployeeWorkingHours extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
