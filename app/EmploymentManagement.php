<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * EmploymentManagement
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class EmploymentManagement extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
