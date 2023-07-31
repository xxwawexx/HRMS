<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * EmployeeDocuments
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class EmployeeDocuments extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
