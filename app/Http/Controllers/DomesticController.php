<?php

namespace App\Http\Controllers;

use App\Deposit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Btc;
use App\Bank;
use App\User;
use App\Otp;
use App\Setting;
use App\Transaction;
use App\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;

class DomesticController extends Controller
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
        if (Auth::user()->account_status==0) {
            $error = "Your account has been temporarily suspended due to suspicious inactivity in the account please kindly visit your branch for reactivatation";
            return redirect()->route('home')->withErrors([$error]);
        }

        $user_id = Auth::user()->id;
        $transactions = Transaction::where('deleted_at', NULL)->where('bank_name', 'Domestic Transaction')->where('sender_id', Auth::user()->account_number)->orderBy('created_at', 'desc')->get();

        $recieves = Transaction::where('deleted_at', NULL)->where('bank_name', 'Domestic Transaction')->where('status', 'Approved')->where('rec_number', Auth::user()->account_number)->orderBy('created_at', 'desc')->get();
        return view('user.domestic', compact('transactions', 'recieves'));
    }

    public function interbank()
    {
        if (Auth::user()->account_status==0) {
            $error = "Your account has been temporarily suspended due to suspicious inactivity in the account please kindly visit your branch for reactivatation";
            return redirect()->route('home')->withErrors([$error]);
        }
        $user_id = Auth::user()->id;
        $transactions = Transaction::where('deleted_at', NULL)->where('bank_name', '!=', 'Domestic Transaction')->where('sender_id', Auth::user()->account_number)->orderBy('created_at', 'desc')->get();

        $recieves = Transaction::where('deleted_at', NULL)->where('bank_name', '!=', 'Domestic Transaction')->where('status', 'Approved')->where('rec_number', Auth::user()->account_number)->orderBy('created_at', 'desc')->get();
        return view('user.interbank', compact('transactions', 'recieves'));
    }

    public function store(Request $request)
    {
        $account_number = $request->rec_number;
        $user = User::where('deleted_at', NULL)->where('account_number', $account_number)->where('account_number', '!=', Auth::user()->account_number)->first();

        $this->validate($request, [
            'rec_number' => 'required|string',
            'amount' => 'required|string',
            'pin' => 'required|string|max:4',
        ]);

        if (isset($user)) {
            if (Auth::user()->pin==$request->pin) {
                if (Auth::user()->balance>=$request->amount) {
                    $transaction = new Transaction();
                    $transaction->transaction_id = rand();
                    $transaction->rec_number = $account_number;
                    $transaction->rec_email = $user->email;
                    $transaction->rec_name = $user->name;
                    $transaction->rec_phone = $user->phone;
                    $transaction->amount = $request->amount;
                    $transaction->bank_name = 'Domestic Transaction';
                    $transaction->currency_type = Auth::user()->currency_type;
                    $transaction->sender_id = Auth::user()->account_number;
                    $transaction->description = $request->description;
                    $transaction->status ='Pending';
                    $transaction->main_date = Carbon::today();
                    $transaction->save();

                    $myaccount = User::find(Auth::user()->id);
                    $myaccount->balance = $myaccount->balance - $request->amount;
                    $myaccount->account_balance = $request->amount + $myaccount->account_balance;
                    $myaccount->update(); 

                    $last_transact = Transaction::where('deleted_at', NULL)->where('sender_id',  Auth::user()->account_number)->latest()->first();
                    $otp = new Otp();
                    $otp->transaction_id = $last_transact->transaction_id;
                    $otp->otp = rand(1000,9999);
                    $otp->date_expires = Carbon::now()->addMinutes(10);
                    $otp->save();
                    
                    $last_otp = Otp::where('deleted_at', NULL)->where('transaction_id', $last_transact->transaction_id)->first();
                    
                    $to = Auth::user()->email; // Send email to our user
                    /*$subject = 'Transaction Initiation | Skywing Invest Bank'; // Give the email a subject 
                    
                    $message = '<html><body>';
                    $message .= '<img src="https://dashboard.skywinginvest.com /storage/logo/hQh6mrPP1MIVFb0GZAfW2uLT7DiRkhRoVuiemKL2.png" alt="Website Change Request" />';
                    $message .= '<span style="border-color: #666; pading:10px">';
                    $message = '
                    Hello '.Auth::user()->name.',
        
                    You have initated a transfer of '.$request->amount.' '. Auth::user()->currency_type. ' to '.$user->name. 
                    '. The transfer is still pending. You should visit your internet banking platform to view and complete your transactions.</br>'.
                    
                    'Your transaction details is as follow;</br>
                    
                    Transaction ID: '.$last_transact->transaction_id.'</br>
                    
                    Amount: '.$request->amount.' '. Auth::user()->currency_type.'</br>
                    
                    OTP: '.$last_otp->otp.'</br>
                        
                    Do note that your OTP expires after 10minutes;</br>
                        
                    Best Regards,
                    The Support Team,
                    Skywing Invest Bank;
                   '; // Our message above including the link
                    $message .= '</span>';
                    $mainmessage = strip_tags($message); 
                    $headers = 'From:noreply@skywinginvest.com ' . "\r\n";; // Set from headers
                    mail($to, $subject, $mainmessage, $headers); // Send our email
                    */
                    $status = 'You have initated a transfer of '.$request->amount. Auth::user()->currency_type. ' to '.$user->name. '. The transfer is still pending, check your email and check for your OTP to complete your transaction';
                    return redirect()->back()->with('success', $status);  
                }
                else
                {
                    $error = 'You do not have upto '.$request->amount.Auth::user()->currency_type. ' in your account';
                    return redirect()->back()->withErrors([$error]);
                }
            }
            else
            {
                $error = "PIN incorrect!!!";
                return redirect()->back()->withErrors([$error]);
            }
        }
        else
        {
            $error = "Account not found!!!";
            return redirect()->back()->withErrors([$error]);
        }
    }

    public function storeinterbank(Request $request)
    {
        $account_number = $request->rec_number;
      
        if (Auth::user()->pin==$request->pin) {
            if (Auth::user()->balance>=$request->amount) {
                $transaction = new Transaction();
                $transaction->transaction_id = rand();
                $transaction->rec_number = $account_number;
                $transaction->rec_email = $request->rec_email;
                $transaction->rec_name = $request->rec_name;
                $transaction->rec_phone = $request->rec_phone;
                $transaction->amount = $request->amount;
                $transaction->bank_name = $request->bank_name;
                $transaction->currency_type =$request->currency_type;
                $transaction->sender_id = Auth::user()->account_number;
                $transaction->description = $request->description;
                $transaction->status ='Pending';
                $transaction->main_date = Carbon::today();
                $transaction->save();

                $myaccount = User::find(Auth::user()->id);
                $myaccount->balance = $myaccount->balance - $request->amount;
                $myaccount->account_balance = $request->amount + $myaccount->account_balance;
                $myaccount->update(); 
                
                $last_transact = Transaction::where('deleted_at', NULL)->where('sender_id',  Auth::user()->account_number)->latest()->first();
                $otp = new Otp();
                $otp->transaction_id = $last_transact->transaction_id;
                $otp->otp = rand(1000,9999);
                $otp->date_expires = Carbon::now()->addMinutes(10);
                $otp->save();
                
                $last_otp = Otp::where('deleted_at', NULL)->where('transaction_id', $last_transact->transaction_id)->first();
                    
                    

                $status = 'You have initated a transfer of '.$request->amount. $request->currency_type. ' to '.$request->rec_name. '. The transfer is still pending';
                
                $to = Auth::user()->email; // Send email to our user
                $subject = 'Transaction Initiation | Skywing Invest Bank'; // Give the email a subject 
                $message = '
                Hello '.Auth::user()->name.',
    
                You have initated a transfer of '.$request->amount. $request->currency_type. ' to '.$request->rec_name.
                
                '. The transfer is still pending. You should visit your internet banking platform to view and complete your transactions.</br>'.
                    
                    'Your transaction details is as follow;</br>
                    
                    Transaction ID: '.$last_transact->transaction_id.'</br>
                    
                    Amount: '.$request->amount.' '. Auth::user()->currency_type.'</br>
                    
                    OTP: '.$last_otp->otp.'</br>
                        
                    Do note that your OTP expires after 10minutes;</br>
                        
                    Best Regards,
                    The Support Team,
                    Skywing Invest Bank;
                '; // Our message above including the link
                $message .= '</span>';
                $mainmessage = strip_tags($message); 
                $headers = 'From:noreply@skywinginvest.com ' . "\r\n";; // Set from headers
                //mail($to, $subject, $mainmessage, $headers); // Send our email
                return redirect()->back()->with('success', $status); 
            }
            else{
                $error = 'You do not have upto '.$request->amount. $request->currency_type. ' in your account';
                return redirect()->back()->withErrors([$error]);
            }
        }
        else
        {
            $error = "PIN incorrect!!!";
            return redirect()->back()->withErrors([$error]);
        }
    }

    public function getuser($account_number)
    {
        $user = User::where('deleted_at', NULL)->where('account_number', $account_number)->where('account_number', '!=', Auth::user()->account_number)->first();
        return response()->json($user);
    }


    public function viewtransaction($id)
    {
        $transaction = $this->transaction_data($id);
        //return $transaction;
        //$transaction = Transaction::find($id);
        $user = User::where('deleted_at', NULL)->where('account_number', $transaction->sender_id)->first();

        if ($transaction) {
            return view('user.viewtransaction', compact('transaction', 'user'));
        }
        return back();
    }

    public function transaction_data($id)
    {
        $transaction = Transaction::find($id);
        return $transaction;
    }

    public function viewpdf($id){

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->converted_data($id));
        $pdf->stream();
        return $pdf->stream();
    }


    public function converted_data($id){
        $transaction = $this->transaction_data($id);
        $user = User::where('deleted_at', NULL)->where('account_number', $transaction->sender_id)->first();
        $setting = Setting::find(1);
        $output = '
            <div style"pading:100px>
                <img src="'.asset('storage').'/'.$setting->logo.'" style="height: 60px; display: inline-block; display: block; margin-left: 270px; margin-right: auto; width: 140px;">
        
            
                <div style="text-align:center; margin-top:70px">
                    <h2>'.$setting->sitename.' - Money Transfer</h2>
                    <p>Transaction Detail<br>
                    Transaction ID = '.$transaction->transaction_id.'
                    </p>
                </div>

                <div style="float:left">
                    <p><b>Payee Details</b></p>
                    <p>
                        Account Number: '.substr($transaction->sender_id, 0, 7).' ***** <br>
                        Account Name: '.ucwords($user->name).'<br>
                    </p>

                    <p><b>Transaction Info</b></p>
                    <p>
                        Value Date: '.\Carbon\Carbon::createFromTimeStamp(strtotime($transaction->main_date))->toFormattedDateString().'<br>
                        Purpose of Transaction: '.ucwords($transaction->description).'<br>
                    </p>
                </div>

                <div style="float:right">
                    <p><b>Beneficiary Details</b></p>
                    <p>
                        Account Number/IBAN/Routing: '.$transaction->rec_number.'<br>
                        Account Name: '.ucwords($transaction->rec_name).'<br>
                        Beneficiary Bank: '.ucwords($transaction->bank_name).'<br>
                        Amount: '.$transaction->amount.' '.$transaction->currency_type.'<br>
                    </p>
                </div>

                <div style="margin-top:200px">
                    <p>It is your responsibility to ensure that the details provided by you in making your money transfer request are correct. If incorrect details are provided by you, your transfer may be unsuccessful or may be paid to an unintended recipient and they check that the details provided by you are correct.</p>
                    <p>You cannot delete or cancel an International Money Transfer payment instruction within Internet Banking. If you wish to delete or cancel a payment instruction please contact us at support@skywinginvest.com .</p>
                    <p>If you get this this message by error please contact us at support@skywinginvest.com . Alter or any attempt to use the material or infomation on this slip can result to law suits.</p>
                </div>
            </div>
        ';
        return $output;
    }

    public function otp(Request $request)
    {
       
        $otp = Otp::where('transaction_id', $request->transaction_id)->where('otp', $request->otp)->where('deleted_at', NULL)->first();

        if ($otp) {
            if ($otp->date_expires<=Carbon::now()) {
                $error = "OTP has expired!!!";
                $transaction = Transaction::where('deleted_at', NULL)->where('transaction_id', $request->transaction_id)->first();
                $transaction->status = "Cancelled";

                $sender_id = $transaction->sender_id;
                $sender_acct = User::where('deleted_at', NULL)->where('account_number', $sender_id)->first();
                $sender_acct->account_balance = $sender_acct->account_balance - $transaction->amount;
                $sender_acct->balance = $sender_acct->balance + $transaction->amount;
                $sender_acct->update();
             
                $transaction->update();
                Otp::Destroy($otp->id);
                return redirect()->back()->withErrors([$error]);
            }
            else{
                if (Auth::user()->account_status=="0"){
                    $error = "Your account has been temporarily suspended due to suspicious inactivity in the account please kindly visit your branch for reactivatation";
                    return redirect()->back()->withErrors([$error]);
                }
                else
                {
                    $transaction = Transaction::where('deleted_at', NULL)->where('transaction_id', $request->transaction_id)->first();
                    $transaction->status = "Approved";
    
                    if ($transaction->bank_name=="Domestic Transaction") {
                        $sender_id = $transaction->sender_id;
                        $sender_acct = User::where('deleted_at', NULL)->where('account_number', $sender_id)->first();
                        $sender_acct->account_balance = $sender_acct->account_balance - $transaction->amount;
                        $sender_acct->update();
        
    
                        $receiver_id = $transaction->rec_number;
                        $receiver_acct = User::where('deleted_at', NULL)->where('account_number', $receiver_id)->first();
                        $receiver_acct->balance = $receiver_acct->balance + $transaction->amount;
                        $receiver_acct->update();

                        $account = new Account();
                        $account->user_id = $sender_acct->id;
                        $account->type = 'debit';
                        $account->amount = $transaction->amount;
                        $account->purpose = 'Domestic transfer to '.$receiver_id;
                        $account->save();

                        $account = new Account();
                        $account->user_id = $receiver_acct->id;
                        $account->type = 'credit';
                        $account->amount = $transaction->amount;
                        $account->purpose = 'Recieved from '.$sender_id;
                        $account->save();


                             //Sender
                        $to1 = Auth::user()->email; // Send email to our user
                        $subject1 = 'Transaction Notification | Skywing Invest Bank'; // Give the email a subject 
                        $message1 = '
                        Hello '.Auth::user()->name.',
                            There is transaction notification on your account;<br>

                            Account Number: '.$transaction->sender_id;'

                            Amount: '.$transaction->amount. $transaction->currency_type. '<br>
                            Transaction Narrative : '.$transaction->description.'<br>
                            Transaction Date : '.$transaction->main_date.'<br>
                            Balance : '.Auth::user()->balance.'<br>
                                
                            Best Regards,
                            The Support Team,
                            Skywing Invest Bank;
                        '; // Our message above including the link
                        $message1 .= '</span>';
                        $mainmessage1 = strip_tags($message1); 
                        $headers1 = 'From:noreply@skywinginvest.com ' . "\r\n";; // Set from headers
                        //mail($to1, $subject1, $mainmessage1, $headers1); // Send our email

                              //Reciever
                        $to = $receiver_acct->email; // Send email to our user
                        $subject = 'Transaction Notification | Skywing Invest Bank'; // Give the email a subject 
                        $message = '
                        Hello '.$receiver_acct->name.',
                            There is transaction notification on your account;<br>

                            Account Number: '.$receiver_acct->account_number;'

                            Amount: '.$transaction->amount. $transaction->currency_type. '<br>
                            Transaction Narrative : '.$transaction->description.'<br>
                            Transaction Date : '.$transaction->main_date.'<br>
                            Balance : '.$receiver_acct->balance.'<br>
                                
                            Best Regards,
                            The Support Team,
                            Skywing Invest Bank;
                        '; // Our message above including the link
                        $message .= '</span>';
                        $mainmessage = strip_tags($message); 
                        $headers = 'From:noreply@skywinginvest.com ' . "\r\n";; // Set from headers
                        //mail($to, $subject, $mainmessage, $headers); // Send our email
                    }
                    else
                    {
                        $sender_id = $transaction->sender_id;
                        $sender_acct = User::where('deleted_at', NULL)->where('account_number', $sender_id)->first();
                        $sender_acct->account_balance = $sender_acct->account_balance - $transaction->amount;
                        $sender_acct->update();

                        $account = new Account();
                        $account->user_id = $sender_acct->id;
                        $account->type = 'debit';
                        $account->amount = $transaction->amount;
                        $account->purpose = 'International transfer to '.$transaction->rec_number;
                        $account->save();


                              //Sender
                        $to1 = Auth::user()->email; // Send email to our user
                        $subject1 = 'Transaction Notification | Skywing Invest Bank'; // Give the email a subject 
                        $message1 = '
                        Hello '.Auth::user()->name.',
                            There is transaction notification on your account;<br>

                            Account Number: '.$transaction->sender_id;'

                            Amount: '.$transaction->amount. $transaction->currency_type. '<br>
                            Transaction Narrative : '.$transaction->description.'<br>
                            Transaction Date : '.$transaction->main_date.'<br>
                            Balance : '.Auth::user()->balance.'<br>
                                
                            Best Regards,
                            The Support Team,
                            Skywing Invest Bank;
                        '; // Our message above including the link
                        $message1 .= '</span>';
                        $mainmessage1 = strip_tags($message1); 
                        $headers1 = 'From:noreply@skywinginvest.com ' . "\r\n";; // Set from headers
                        //mail($to1, $subject1, $mainmessage1, $headers1); // Send our email
                    }

                    $transaction->update();
                    $status = "Success";
                    Otp::Destroy($otp->id);
                    return redirect()->back()->with('success', $status); 
                }
            }    
        }
        else
        {
            $error = "OTP does not exist!!!";
            return redirect()->back()->withErrors([$error]);
        }
    }


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
