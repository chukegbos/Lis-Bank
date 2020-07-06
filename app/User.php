<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'account_number', 'balance', 'phone', 'image', 'id_card', 'address', 'city', 'state', 'country', 'zip_code', 'acc_name', 'acc_number', 'bank_name', 'account_status', 'login_status', 'account_number', 'account_balance', 'total_balance', 'account_type',  'currency_type', 'pin', 'sort_code', 'toc', 'tc', 'tax', 'irdc', 'atc', 'iban', 'swift_code', 'setup', 'ban_user'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getTotalBalanceAttribute()
    {
        return $this->attributes['balance'] + $this->attributes['account_balance'];
    }
}
