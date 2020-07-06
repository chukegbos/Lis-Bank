<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Price;
use App\Setting;
use App\Account;
use App\Vest;
use App\Btc;
use App\Bank;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VestController extends Controller
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
        $savings = Vest::where('deleted_at', NULL)->where('user_id', Auth::user()->id)->get();
        $thesavings = Vest::where('deleted_at', NULL)->where('user_id', Auth::user()->id) ->where('status', 0)->latest()->get();
        foreach ($thesavings as $saving) {
            if ($saving->due_date < Carbon::today()) {
                $user = Auth::user();
                $user->balance = Auth::user()->balance + $saving->amount;
                $user->update();

                $isave = Vest::find($saving->id);
                $isave->status = 1;
                $isave->update();

                $account = new Account();
                $account->user_id = Auth::user()->id;
                $account->type = 'credit';
                $account->amount = $saving->amount;
                $account->purpose = 'PiggyVest CreditBack ('.$saving->purpose.')';
                $account->save();
            }
        }
        return view('user.vests', compact('savings'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $balance = Auth::user()->balance;

        Vest::create([
            'user_id' => $request['user_id'],
            'purpose' => $request['purpose'],
            'amount' => $request['amount'],
            'due_date' => $request['due_date'],
        ]);

        $user = Auth::user();
        $user->balance = $balance - $request->amount;
        $user->update();
        
        $account = new Account();
        $account->user_id = $user_id;
        $account->type = 'debit';
        $account->amount = $request->amount;
        $account->purpose = 'PiggyVest Savings ('.$request->purpose.')';
        $account->save();

        return redirect()->back()->with('success', 'Savings successful created!');
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
