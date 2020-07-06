<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Admin;
use App\Setting;
use App\Btc;
use App\Bank;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use DB;

class SettingController extends Controller
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
        $userss = Admin::get();
        $banks = Bank::where('deleted_at', NULL)->get();
        $btcs = Btc::where('deleted_at', NULL)->get();
        return view('admin.setting', compact('userss', 'banks', 'btcs'));
    }

    public function passwordget()
    {   
        $error = request('passworderror'); 
        return view('admin.password', compact('error'));
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

    /**

    
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    public function create_admin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|string|max:191|email|unique:users',
            'password' => 'required|string|min:8',
        ]);
        
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->back()->with('success', 'Admin successful created!');
    }
    
    public function update_admin(Request $request, $id)
    {
        
        $this->validate($request, [
            'password' => 'required|string|min:8',
        ]);
        $user = Admin::find($id);

        $password = ($request['password']) ?  Hash::make($request['password']) : $user->password ;
        $user->update([
            'password' => $password,
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Admin successful updated!');
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);
        if ($request->sitename) {
            $this->validate($request, [
                'sitename' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);
        }
        elseif ($request->about) {
            
        }
        $setting->update($request->all());
        return redirect()->back()->with('success', 'Setting successful updated!');
    }

    public function logoupdate(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:8048'
        ]);

        $file = $request->file('logo');
        $path = Storage::disk('public')->putFile('logo', $file);

        $setting->update([
            'logo' => $path,
        ]);
        return redirect()->back()->with('success', 'Logo successful updated!');
    }

    public function bank(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
        ]);
        
        Bank::create([
            'name' => $request->name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
        ]);

        return redirect()->back()->with('success', 'Bank details successful created!');
    }
    
    public function update_bank(Request $request, $id)
    {
        
        $this->validate($request, [
            'name' => 'required',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
        ]);

        $bank = Bank::find($id);

        $bank->update([
            'name' => $request->name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
        ]);

        return redirect()->back()->with('success', 'Bank details successful updated!');
    }
   
    public function destroy_bank($id)
    {
        Bank::destroy($id);
        return redirect()->back()->with('success', 'Bank Details Deleted!');
    }


    public function btc(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'detail' => 'required|string',
        ]);
        
        if ($request->image) {
            $file = $request->file('image');
            $path = Storage::disk('public')->putFile('btc', $file);
            $image = $path;
        }

        Btc::create([
            'name' => $request->name,
            'detail' => $request->detail,
            'image' => $image,
        ]);

        return redirect()->back()->with('success', 'Crypto details successful created!');
    }
    
    public function update_btc(Request $request, $id)
    {
        
        $this->validate($request, [
            'name' => 'required',
            'detail' => 'required|string',
        ]);

        $btc = Btc::find($id);

        if ($request->image) {
            $file = $request->file('image');
            $path = Storage::disk('public')->putFile('btc', $file);
            $image = $path;
        }
        else{
            $image = $btc->image;
        }
        

        $btc->update([
            'name' => $request->name,
            'detail' => $request->detail,
            'image' => $image,
        ]);

        return redirect()->back()->with('success', 'Crypto details successful updated!');
    }
   
    public function destroy_btc($id)
    {
        Btc::destroy($id);
        return redirect()->back()->with('success', 'Crypto Details Deleted!');
    }

    public function admin_destroy($id)
    {
        Admin::destroy($id);
        return redirect()->back()->with('success', 'Admin deleted!');
    }

    public function team()
    {   
        $boards = Board::where('deleted_at', NULL)->get();
        $managements = DB::table('managements')->where('deleted_at', NULL)->get();
        $management = Management::get();
        return view('admin.team', compact('managements', 'boards'));
    }
}
