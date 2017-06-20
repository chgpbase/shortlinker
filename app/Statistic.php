<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $table = 'statistic';

    protected $fillable = ['link_id', 'country', 'city', 'user_agent'];
}
