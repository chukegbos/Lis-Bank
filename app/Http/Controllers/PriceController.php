<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Price;
use App\Loan;
use App\Setting;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $prices = Price::where('deleted_at', NULL)->orderBy('created_at', 'asc')->get();
        return view('admin.price', compact('prices'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'min' => 'required|string|max:750',
            'max' => 'required|string|max:250',
            'compound' => 'required|string|max:250',
            'commission' => 'required|string|max:250',
        ]);

        $slug = Str::slug($request->name, '-');

        Price::create([
            'name' => $request['name'],
            'min' => $request['min'],
            'max' => $request['max'],
            'compound' => $request['compound'],
            'commission' => $request['commission'],
            'slug' => $slug,
        ]);

        return redirect()->back()->with('success', 'Price successful created!');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'min' => 'required|string|max:750',
            'max' => 'required|string|max:250',
            'compound' => 'required|string|max:250',
            'commission' => 'required|string|max:250',
        ]);

        $slug = Str::slug($request->name, '-');

        $price = Price::find($id);

        $price->update([
            'name' => $request['name'],
            'min' => $request['min'],
            'max' => $request['max'],
            'compound' => $request['compound'],
            'commission' => $request['commission'],
            'slug' => $slug,
        ]);

        return redirect()->back()->with('success', 'Price successful updated!');
    }

    public function destroy($id)
    {
        Price::destroy($id);
        return redirect()->back()->with('success', 'Price deleted!');
    }

    public function loanindex()
    {
        $prices = Loan::where('deleted_at', NULL)->orderBy('created_at', 'asc')->get();
        return view('admin.loan', compact('prices'));
    }
    
    public function loancreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'min' => 'required|string|max:750',
            'max' => 'required|string|max:250',
            'compound' => 'required|string|max:250',
            'commission' => 'required|string|max:250',
        ]);

        $slug = Str::slug($request->name, '-');

        Loan::create([
            'name' => $request['name'],
            'min' => $request['min'],
            'max' => $request['max'],
            'compound' => $request['compound'],
            'commission' => $request['commission'],
            'slug' => $slug,
        ]);

        return redirect()->back()->with('success', 'Loan price successful created!');
    }

    public function loanupdate(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'min' => 'required|string|max:750',
            'max' => 'required|string|max:250',
            'compound' => 'required|string|max:250',
            'commission' => 'required|string|max:250',
        ]);

        $slug = Str::slug($request->name, '-');

        $price = Loan::find($id);

        $price->update([
            'name' => $request['name'],
            'min' => $request['min'],
            'max' => $request['max'],
            'compound' => $request['compound'],
            'commission' => $request['commission'],
            'slug' => $slug,
        ]);

        return redirect()->back()->with('success', 'Loan price successful updated!');
    }

    public function loandestroy($id)
    {
        Loan::destroy($id);
        return redirect()->back()->with('success', 'Loan price deleted!');
    }
}
