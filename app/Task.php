<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Task
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class Task extends Model
{
    protected $guarded = [];
}
