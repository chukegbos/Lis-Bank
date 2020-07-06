<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Price;
use App\Vest;
use Auth;
use App\User;

class Withdraw extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'amount', 'status'
    ];

    protected $dates = [
        'deleted_at'
    ];
}
