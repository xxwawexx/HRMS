<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * GovernmentID
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class GovernmentID extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
