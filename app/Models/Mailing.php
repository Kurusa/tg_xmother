<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model {

    protected $table = 'mailing';
    protected $fillable = ['user_id', 'value', 'text', 'image', 'button', 'whom'];

}