<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Price;
use App\Investment;
use Auth;
use App\User;

class Investment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'price_id', 'user_id', 'withdrawal_date', 'amount', 'status', 'balance', 'paid', 'transaction_id', 'withdraw'
    ];

    protected $dates = [
        'deleted_at', 
    ];

    public function getBalanceAttribute()
    {
        $date = Carbon::now();
        $fromData = $this->attributes['created_at'];

        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $fromData);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $date);

        $days = $to->diffInDays($from);

        $amount = $this->attributes['amount'];
        $price_id = $this->attributes['price_id'];

        $price = Price::find($price_id);
        if (isset($price)) {
            //$balance = ((($price->commission/100)*($amount)) * $days) + $amount;
            $balance = (($price->commission/100)*($amount)) + $amount;
            return $balance;
        }
        return "0";    
    }

    public function getWithdrawalDateAttribute()
    {
        $price_id = $this->attributes['price_id'];
        $price = Price::find($price_id);
        $fromData = $this->attributes['created_at'];
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $fromData);
        return $to->addDays($price->compound);  
    }

    public function getStatusAttribute()
    {
        $compound = $this->attributes['compound'];
        $fromData = $this->attributes['created_at'];
        $status = $this->attributes['status'];
        $paid = $this->attributes['paid'];

        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $fromData);
        $day = $to->addDays($compound);
        if ($day >= Carbon::now() && $status==0) {
            return 'In Progress';
        }
        elseif($status==0 && $paid==1)
        {
            return "Requested";
        }

        elseif($status==0)
        {
            return "Click to withdraw";
        }

        elseif($status==1)
        {
            return "On Queue";
        }
        else
        {
            return "Completed";
        }
        
    }
}
