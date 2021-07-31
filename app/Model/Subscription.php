<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['expiry_date'];
}
