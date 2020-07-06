<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Price extends Model
{
    
    use SoftDeletes;
    protected $fillable = [
        'name', 'slug', 'min', 'max', 'commission', 'compound'
    ];

    protected $dates = [
        'deleted_at', 
    ];
}
