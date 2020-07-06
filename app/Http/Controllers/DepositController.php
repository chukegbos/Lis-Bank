<?php

namespace App\Http\Controllers;

use App\Deposit;
use Illuminate\Http\Request;
use Auth;
use App\Btc;
use App\Bank;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use DB;

class DepositController extends Controller
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
        $user_id = Auth::user()->id;
        $deposits = Deposit::where('user_id', $user_id)->where('deleted_at', NULL)->latest()->get();
        $banks = Bank::where('deleted_at', NULL)->get();
        $btcs = Btc::where('deleted_at', NULL)->get();
        return view('user.deposits', compact('deposits', 'banks', 'btcs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->file('pop')) {
            $file = $request->file('pop');
            $pop = Storage::disk('public')->putFile('pop', $file);

            $deposit = new Deposit();
            $deposit->user_id = Auth::user()->id;
            $deposit->ref_id = rand(2, 888888);
            $deposit->amount = $request->amount;
            $deposit->method = 'Bank Deposit';
            $deposit->status = 'pending';
            $deposit->charge = 0;
            $deposit->payable = $request->amount;
            $deposit->pop = $pop;
            $deposit->save();
            return redirect()->back()->with('success', 'Proof of payment submitted.'); 
        }
        else
        {
            $btc = Btc::where('deleted_at', NULL)->find($request->id);
            $deposit = new Deposit();
            $deposit->user_id = Auth::user()->id;
            $deposit->ref_id = rand(2, 888888);
            $deposit->amount = $request->amount;
            $deposit->method = $btc->name;
            $deposit->status = 'pending';
            $deposit->charge = (($btc->charge)/100) * $request->amount;
            $deposit->payable = ((($btc->charge)/100) * $request->amount) + $request->amount;
            $deposit->save();
            return redirect()->route('invoice', array('ref_id' => $deposit->ref_id, 'coin_id' => $request->id));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $ref_id = request('ref_id');
        $coin_id = request('coin_id');
        $method = request('method');
        if ($coin_id) {
            $btc = Btc::where('deleted_at', NULL)->find($coin_id);
        }
        else
        {
            $btc = Btc::where('deleted_at', NULL)->where('name', $method)->first();
        }
        $invoice = Deposit::where('deleted_at', NULL)->where('ref_id', $ref_id)->first();
        return view('user.invoice', compact('invoice', 'btc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit $deposit)
    {
        //
    }
}
