<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Account;
use App\User;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->ban_user==0){
            Auth::logout();
            $error = "You are banned from accessing this application, contact the administrator.";
            return redirect()->back()->withErrors([$error]);
        }

        if (Auth::user()->setup==0) {
            return redirect()->route('profile')->with('success', 'You need to complete your account information to proceed.');
        }
        return view('user.index');
    }

    public function support()
    {
        return view('user.support');
    }

    public function accounts()
    {
        $accounts = Account::where('deleted_at', NULL)->where('user_id', Auth::user()->id)->latest()->get();
        return view('user.account', compact('accounts'));
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function updateprofile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pin' => 'required|string|max:4',
        ]);

        if ($request->file('id_card')) {
            $file = $request->file('id_card');
            $id_card = Storage::disk('public')->putFile('id_card', $file);

            $user->update([
                'id_card' => $id_card,
            ]);
        }

        if ($request->file('image')) {
            $file = $request->file('image');
            $image = Storage::disk('public')->putFile('image', $file);

            $user->update([
                'image' => $image,
            ]);
        }

        $user->update([
            'setup' => 1,
            'pin' => $request->pin,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->name,
            'city' => $request->email,
            'state' => $request->phone,
            'country' => $request->name,
            'zip_code' => $request->email,
            'acc_name' => $request->phone,
            'acc_numbe' => $request->name,
            'bank_name' => $request->email,
            'sort_code ' => $request->sort_code ,
            'account_type' => $request->account_type,
            'currency_type' => $request->currency_type,
            'toc' => $request->toc,
            'tc' => $request->tc,
            'tax' => $request->tax,
            'irdc' => $request->irdc,
            'atc' => $request->atc,
            'iban' => $request->iban,
            'swift_code' => $request->swift_code,
            'bank_name' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profile successful updated!');
    }

    public function show($id)
    {   
        Auth::loginUsingId($id, true);
        return redirect()->route('home');
    }

    public function passwordget()
    {   
        $error = request('passworderror'); 
        return view('user.password', compact('error'));
    }

    public function password(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->withErrors(['Your current password does not matches with the password you provided. Please try again.']);
        }
 
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            return redirect()->back()->withErrors(['New Password cannot be same as your current password. Please choose a different password.']);
        }
 
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with('success', 'Password changed successfully.');  
    }
}
