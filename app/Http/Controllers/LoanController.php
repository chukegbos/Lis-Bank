<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use App\Loan;
use App\Scheme;
use App\Account;
use App\Btc;
use App\Bank;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LoanController extends Controller
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
        $investments = Scheme::where('schemes.deleted_at', NULL)
            ->where('schemes.user_id', Auth::user()->id)
            ->join('loans', 'schemes.price_id', '=', 'loans.id')
            ->where('loans.deleted_at', NULL)
            ->select(
                'loans.name as name',
                'loans.commission as commission',
                'schemes.id as id',
                'schemes.price_id as price_id',
                'schemes.withdraw as withdraw',
                'schemes.transaction_id as transaction_id',
                'schemes.balance as balance',
                'loans.compound as compound',
                'schemes.amount as amount',
                'schemes.status as status',
                'schemes.paid as paid',
                'schemes.created_at as created_at',
                'schemes.withdrawal_date as withdrawal_date'
            )
            ->latest()
            ->get();
        $pricings = Loan::where('deleted_at', NULL)->get();

        $thesavings = Scheme::where('deleted_at', NULL)->where('withdraw', NULL)->get();
        foreach ($thesavings as $saving) {
            if ($saving->withdrawal_date < Carbon::today()) {
                $user = Auth::user();
                $user->balance = Auth::user()->balance + $saving->amount;
                $user->update();

                $isave = Scheme::find($saving->id);
                $isave->withdraw = 1;
                $isave->update();

                $account = new Account();
                $account->user_id = Auth::user()->id;
                $account->type = 'credit';
                $account->amount = $saving->amount;
                $account->purpose = 'Loan payback ('.$saving->transaction_id.')';
                $account->save();
            }
        }
        return view('user.schemes', compact('investments', 'pricings'));
    }

    public function create()
    {
        $loans = Loan::where('deleted_at', NULL)->get();
        return view('user.loan', compact('loans'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $balance = Auth::user()->balance;
        if ($balance < $request->amount) {
            $error = 'You do not have upto '.$request->amount.' USD in your account, upgrade by depositing money in your account and try again!';
            return redirect()->back()->withErrors([$error]);
        }
  
        $scheme = Scheme::create([
            'transaction_id' => rand(2, 29999999999),
            'user_id' => $request['user_id'],
            'price_id' => $request['price_id'],
            'amount' => $request['amount'],
            'status' => 1,
            'paid' => 1,
        ]);

        $user = Auth::user();
        $user->balance = $balance - $request->amount;
        $user->update();
        
        $account = new Account();
        $account->user_id = Auth::user()->id;
        $account->type = 'debit';
        $account->amount = $request->amount;
        $account->purpose = 'scheme ('.$scheme->transaction_id.')';
        $account->save();

        return redirect()->back()->with('success', 'scheme successful approved!');
    }


    public function storewithdraw(Request $request)
    {
        $id = $request->id;
        $scheme = scheme::where('deleted_at', NULL)->find($id);
        $scheme->withdraw = 0;
        $scheme->update();
        return redirect()->back()->with('success', 'Request Submitted!');
    }
    

    public function invoice()
    {
        $id = request('id');
        $scheme = scheme::where('schemes.user_id', Auth::user()->id)
            ->join('loans', 'schemes.price_id', '=', 'loans.id')
            ->where('loans.deleted_at', NULL)
            ->where('schemes.deleted_at', NULL)
            ->select(
                'loans.name as name',
                'loans.commission as commission',
                'schemes.id as id',
                'schemes.transaction_id as transaction_id',
                'schemes.price_id as price_id',
                'schemes.balance as balance',
                'loans.compound as compound',
                'schemes.amount as amount',
                'schemes.status as status',
                'schemes.paid as paid',
                'schemes.created_at as created_at',
                'schemes.withdrawal_date as withdrawal_date'
            )
            ->find($id);
        //return $scheme;
        $banks = Bank::where('deleted_at', NULL)->get();
        $btcs = Btc::where('deleted_at', NULL)->get();
        return view('user.invoice', compact('scheme', 'banks', 'btcs'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdraw($id)
    {
        $scheme = scheme::where('deleted_at', NULL)->find($id);
        return $scheme->price_id;
        return view('user.loan', compact('loans'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function adminshow($id)
    {
        $scheme = scheme::where('deleted_at', NULL)->find($id);
        $scheme->paid = 1;
        $scheme->created_at = carbon::now();
        $scheme->update();
        return redirect()->back()->with('success', 'scheme successful approved!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'views' => 'required|string|max:250',
            'no_of_people' => 'required|string|max:250',
            'amount' => 'required|string|max:250',
        ]);

        $slug = Str::slug($request->name, '-');

        $loan = loan::find($id);

        

        $loan->update([
            'name' => $request['name'],
            'description' => 'required|string|max:750',
            'views' => $request['views'],
            'no_of_people' => $request['no_of_people'],
            'amount' => $request['amount'],
            'description' => $request['description'],
            'slug' => $slug,
        ]);

        return redirect()->back()->with('success', 'loan successful updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        loan::destroy($id);
        return redirect()->back()->with('success', 'loan deleted!');
    }
}
