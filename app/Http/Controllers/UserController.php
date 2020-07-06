<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $users = User::where('deleted_at', NULL)->where('is_admin', NULL)->get();
        return view('admin.users', compact('users'));
    }

    public function show($id)
    {
        Auth::loginUsingId($id, true);
        return redirect()->route('home');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->with('success', 'User deleted!');
    }
}
