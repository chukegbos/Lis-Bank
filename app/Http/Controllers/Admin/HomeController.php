<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Deposit;
use App\Investment;
use App\Scheme;
use App\Account;
use App\User;
use App\Vest;
use App\Withdraw;
use App\Transaction;

class HomeController extends Controller
{
    /**
     * Only Authenticated users for "admin" guard 
     * are allowed.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show Admin Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('admin.home');
    }

    public function deposit()
    {
        $deposits = Deposit::where('deleted_at', NULL)->get();
        return view('admin.deposits', compact('deposits'));
    }

    public function approvedeposit($ref_id)
    {
        $deposit = Deposit::where('deleted_at', NULL)->where('ref_id', $ref_id)->first();
        $deposit->status = 'paid';
        $deposit->update();

        $user = User::find($deposit->user_id);
        $user->balance = $user->balance + $deposit->amount;
        $user->update();

        $account = new Account();
        $account->user_id = $deposit->user_id;
        $account->type = 'credit';
        $account->amount = $deposit->amount;
        $account->purpose = 'Account Deposit';
        $account->save();

        return redirect()->back()->with('success', 'Deposit successful approved!');
    }

    public function destroy($id)
    {
        Deposit::Destroy($id);
        return back();
    }

    public function investments()
    {
        $investments = Investment::where('investments.deleted_at', NULL)
            ->join('prices', 'investments.price_id', '=', 'prices.id')
            ->join('users', 'investments.user_id', '=', 'users.id')
            ->where('prices.deleted_at', NULL)
            ->select(
                'prices.name as name',
                'users.name as fullname',
                'prices.commission as commission',
                'investments.id as id',
                'investments.withdraw as withdraw',
                'investments.price_id as price_id',
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
        return view('admin.investments', compact('investments'));
    }

    public function schemes()
    {
        $investments = Scheme::where('schemes.deleted_at', NULL)
            ->join('loans', 'schemes.price_id', '=', 'loans.id')
            ->join('users', 'schemes.user_id', '=', 'users.id')
            ->where('loans.deleted_at', NULL)
            ->select(
                'loans.name as name',
                'users.name as fullname',
                'loans.commission as commission',
                'schemes.id as id',
                'schemes.withdraw as withdraw',
                'schemes.price_id as price_id',
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
        return view('admin.schemes', compact('investments'));
    }

    public function withdraw()
    {
        $withdraws = Withdraw::where('withdraws.deleted_at', NULL)
            ->join('users', 'withdraws.user_id', '=', 'users.id')
            ->select(
                'users.name as fullname',
                'withdraws.id as id',
                'withdraws.amount as amount',
                'withdraws.status as status',
                'withdraws.created_at as created_at'
            )
            ->latest()
            ->get();
        return view('admin.withdraw', compact('withdraws'));
    }

    public function showwithdraw($id)
    {
        $withdraw = Withdraw::find($id);
        $withdraw->status = 'Paid';
        $withdraw->update();
        return redirect()->back()->with('success', 'Successfully approved!');
    }

    public function save()
    {
        $withdraws = Vest::where('vests.deleted_at', NULL)
            ->join('users', 'vests.user_id', '=', 'users.id')
            ->select(
                'users.name as fullname',
                'vests.id as id',
                'vests.amount as amount',
                'vests.status as status',
                'vests.purpose as purpose',
                'vests.created_at as created_at',
                'vests.due_date as due_date'
            )
            ->latest()
            ->get();
        return view('admin.vest', compact('withdraws'));
    }

    public function transactions(Request $request)
    {
        $transactions = Transaction::where('deleted_at', NULL)->latest()->get();
        return view('admin.alltransactions', compact('transactions'));  
    }

    public function viewtransaction($id)
    {
        $transaction = $this->transaction_data($id);
        $user = User::where('deleted_at', NULL)->where('account_number', $transaction->sender_id)->first();

        if ($transaction) {
            return view('admin.viewtransaction', compact('transaction', 'user'));
        }
        return redirect()->back()->withErrors(['No transaction found!!!']);
    }

    public function transaction_data($id)
    {
        $transaction = Transaction::find($id);
        return $transaction;
    }

    public function searchaccount($account_number)
    {
        $user = User::where('deleted_at', NULL)->where('account_number', $account_number)->first();
        if ($user) {
            return view('admin.viewuser', compact('user'));
        }
        return redirect()->back()->withErrors(['No account found!!!']);
    }

    public function changedate(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->update(['main_date' => $request->main_date]);
        return redirect()->back()->with('success', 'Date Changed!');
    }
    
    public function changestatus(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->status = $request->status;

        if ($request->status="Approved") {
            if ($transaction->bank_name=="Domestic Transaction") {
                $sender_id = $transaction->sender_id;
                $sender_acct = User::where('deleted_at', NULL)->where('account_number', $sender_id)->first();
                $sender_acct->account_balance = $sender_acct->account_balance - $transaction->amount;
                $sender_acct->update();


                $receiver_id = $transaction->rec_number;
                $receiver_acct = User::where('deleted_at', NULL)->where('account_number', $receiver_id)->first();
                $receiver_acct->balance = $receiver_acct->balance + $transaction->amount;
                $receiver_acct->update();
            }
            else
            {
                $sender_id = $transaction->sender_id;
                $sender_acct = User::where('deleted_at', NULL)->where('account_number', $sender_id)->first();
                $sender_acct->account_balance = $sender_acct->account_balance - $transaction->amount;
                $sender_acct->update();
            }
        }
        elseif ($request->status="Cancelled"){
            $sender_id = $transaction->sender_id;
            $sender_acct = User::where('deleted_at', NULL)->where('account_number', $sender_id)->first();
            $sender_acct->account_balance = $sender_acct->account_balance - $transaction->amount;
            $sender_acct->balance = $sender_acct->balance + $transaction->amount;
            $sender_acct->update();
        }
        $transaction->update();
        return redirect()->back()->with('success', 'Status changed!');
    }

    public function ban($id)
    {
        $user = User::find($id);
        if ($user->account_status=="1") {
            $user->account_status = "0";
        }
        else
        {
            $user->account_status = "1";
        }
        $user->update();
        return response()->json($user);
    }

    public function banuser($id)
    {
        $user = User::find($id);
        if ($user->ban_user=="1") {
            $user->ban_user = "0";
        }
        else
        {
            $user->ban_user = "1";
        }
        $user->update();
        return response()->json($user);
    }

    public function resett($id)
    {
        $user = User::find($id);
        $user->pin = "0000";
        $user->update();
        return response()->json($user);
    }

    public function adminchangepassword(Request $request)
    {
        $user = User::find($request->id);
        $user->password = bcrypt($request->get('password'));
        $user->update();
        return redirect()->back()->with('success', 'Password changed!');
    }

    public function addfund(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        $user->balance = $user->balance + $request->balance;
        $user->update();
        return redirect()->back()->with('success', 'Fund Added!');
    } 
}
