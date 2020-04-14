<?php

namespace App\Http\Controllers;

use App\Charity;
use App\UserCharity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnBoarding extends Controller
{
    public function edit() {
        return view('auth.onboarding', [
            'charities_list' => Charity::where('active', true)->get()
        ]);

    }

    public function store(Request $request) {

        foreach($request->input() as $key => $value) {
           if ($key !== "_token" && $key !== "file") {
               UserCharity::create([
                   'user_id' => Auth::id(),
                    'charity_id' => $value
               ]);
           }
        }
        return redirect()->route('home');
    }

}