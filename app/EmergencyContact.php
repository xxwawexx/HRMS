<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * EmergencyContact
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class EmergencyContact extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
