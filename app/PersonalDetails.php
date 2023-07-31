<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * PersonalDetails
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class PersonalDetails extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
