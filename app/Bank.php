<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Bank extends Model
{
    
    use SoftDeletes;
    protected $fillable = [
        'name', 'account_number', 'account_name'
    ];

    protected $dates = [
        'deleted_at', 
    ];
}
