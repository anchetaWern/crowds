<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'service_type_id', 'is_enabled'];
}
