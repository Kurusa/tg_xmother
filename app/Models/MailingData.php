<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailingData extends Model {

    protected $table = 'mailing_data';
    protected $fillable = ['user_id', 'is_pregnant', 'child_age', 'districts', 'expectations'];

}