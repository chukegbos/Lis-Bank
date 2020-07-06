<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rec_number', 'rec_email', 'rec_phone', 'rec_name', 'amount', 'bank_name', 'currency_type', 'sender_id', 'status', 'tc', 'description', 'main_date', 'otp'
    ];
    
    protected $dates = [
        'deleted_at', 'main_date'
    ];
}
