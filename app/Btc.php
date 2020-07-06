<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Btc extends Model
{
    
    use SoftDeletes;
    protected $fillable = [
        'name', 'image', 'detail', 'charge', 'barcode'
    ];

    protected $dates = [
        'deleted_at', 
    ];
}
