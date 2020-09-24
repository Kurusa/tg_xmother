<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChild extends Model {

    protected $table = 'user_child';
    protected $fillable = ['user_id', 'gender', 'birthday'];

}