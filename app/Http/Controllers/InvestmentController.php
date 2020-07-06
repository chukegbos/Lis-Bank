<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Price;
use App\Setting;
use App\Investment;
use App\Account;
use App\Btc;
use App\Bank;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InvestmentController extends Controller
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
        $investments = Investment::where('investments.deleted_at', NULL)
            ->where('investments.user_id', Auth::user()->id)
            ->join('prices', 'investments.price_id', '=', 'prices.id')
            ->where('prices.deleted_at', NULL)
            ->select(
                'prices.name as name',
                'prices.commission as commission',
                'investments.id as id',
                'investments.price_id as price_id',
                'investments.withdraw as withdraw',
                'investments.transaction_id as transaction_id',
                'investments.balance as balance',
                'prices.compound as compound',
                'investments.amount as amount',
                'investments.status as status',
                'investments.paid as paid',
                'investments.created_at as created_at',
                'investments.withdrawal_date as withdrawal_date'
            )
            ->latest()
            ->get();
        $pricings = Price::where('deleted_at', NULL)->get();

        $thesavings = Investment::where('deleted_at', NULL)->where('withdraw', NULL)->get();
        foreach ($thesavings as $saving) {
            if ($saving->withdrawal_date < Carbon::today()) {
                $user = Auth::user();
                $user->balance = Auth::user()->balance + $saving->amount;
                $user->update();

                $isave = Investment::find($saving->id);
                $isave->withdraw = 1;
                $isave->update();

                $account = new Account();
                $account->user_id = Auth::user()->id;
                $account->type = 'credit';
                $account->amount = $saving->amount;
                $account->purpose = 'IV scheme payback ('.$saving->transaction_id.')';
                $account->save();
            }
        }
        return view('user.investments', compact('investments', 'pricings'));
    }

    public function create()
    {
        $prices = Price::where('deleted_at', NULL)->get();
        return view('user.price', compact('prices'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $balance = Auth::user()->balance;
        if ($balance < $request->amount) {
            $error = 'You do not have upto '.$request->amount.' USD in your account, upgrade by depositing money in your account and try again!';
            return redirect()->back()->withErrors([$error]);
        }

        $investment = Investment::create([
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
        $account->purpose = 'Investment ('.$investment->transaction_id.')';
        $account->save();

        return redirect()->back()->with('success', 'Investment successful approved!');
    }


    public function storewithdraw(Request $request)
    {
        $id = $request->id;
        $investment = Investment::where('deleted_at', NULL)->find($id);
        $investment->withdraw = 0;
        $investment->update();
        return redirect()->back()->with('success', 'Request Submitted!');
    }
    

    public function invoice()
    {
        $id = request('id');
        $investment = Investment::where('investments.user_id', Auth::user()->id)
            ->join('prices', 'investments.price_id', '=', 'prices.id')
            ->where('prices.deleted_at', NULL)
            ->where('investments.deleted_at', NULL)
            ->select(
                'prices.name as name',
                'prices.commission as commission',
                'investments.id as id',
                'investments.transaction_id as transaction_id',
                'investments.price_id as price_id',
                'investments.balance as balance',
                'prices.compound as compound',
                'investments.amount as amount',
                'investments.status as status',
                'investments.paid as paid',
                'investments.created_at as created_at',
                'investments.withdrawal_date as withdrawal_date'
            )
            ->find($id);
        //return $investment;
        $banks = Bank::where('deleted_at', NULL)->get();
        $btcs = Btc::where('deleted_at', NULL)->get();
        return view('user.invoice', compact('investment', 'banks', 'btcs'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdraw($id)
    {
        $investment = Investment::where('deleted_at', NULL)->find($id);
        return $investment->price_id;
        return view('user.price', compact('prices'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Price  $Price
     * @return \Illuminate\Http\Response
     */
    public function adminshow($id)
    {
        $investment = Investment::where('deleted_at', NULL)->find($id);
        $investment->paid = 1;
        $investment->created_at = carbon::now();
        $investment->update();
        return redirect()->back()->with('success', 'Investment successful approved!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Price  $Price
     * @return \Illuminate\Http\Response
     */
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
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'views' => 'required|string|max:250',
            'no_of_people' => 'required|string|max:250',
            'amount' => 'required|string|max:250',
        ]);

        $slug = Str::slug($request->name, '-');

        $price = Price::find($id);

        

        $price->update([
            'name' => $request['name'],
            'description' => 'required|string|max:750',
            'views' => $request['views'],
            'no_of_people' => $request['no_of_people'],
            'amount' => $request['amount'],
            'description' => $request['description'],
            'slug' => $slug,
        ]);

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
