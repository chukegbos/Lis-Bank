<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Price;
use App\Setting;
use App\Account;
use App\Withdraw;
use App\Btc;
use App\Bank;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $withdraws = Withdraw::where('deleted_at', NULL)->where('user_id', Auth::user()->id)->latest()->get();
        return view('user.withdraws', compact('withdraws'));
    }


    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $balance = Auth::user()->balance;

        Withdraw::create([
            'user_id' => $request['user_id'],
            'amount' => $request['amount'],
        ]);

        $user = Auth::user();
        $user->balance = $balance - $request->amount;
        $user->update();
        
        $account = new Account();
        $account->user_id = $user_id;
        $account->type = 'debit';
        $account->amount = $request->amount;
        $account->purpose = 'Withdrawal to Bank Account';
        $account->save();

        return redirect()->back()->with('success', 'Withdrawal successful initiated!');
    }

    public function edit(Price $Price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Price  $Price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->back()->with('success', 'Price successful updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Price  $Price
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Price::destroy($id);
        return redirect()->back()->with('success', 'Price deleted!');
    }
}
