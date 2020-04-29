<?php

namespace App\Http\Controllers;

use App\Models\Charity;
use App\Models\UserCharity;
use App\Repositories\Interfaces\StripeServiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnBoarding extends Controller
{
    private $stripeServiceRepository;
    public function __construct(StripeServiceRepositoryInterface $stripeServiceRepository)
    {
        $this->stripeServiceRepository = $stripeServiceRepository;
    }

    public function edit() {
        $customer = $this->stripeServiceRepository->getCustomerFromUser(Auth::user());
        $intent = $this->stripeServiceRepository->createSetupIntentFromCustomer($customer->id);

        return view('auth.onboarding', [
            'charities_list' => Charity::where('active', true)->orderBy('name', 'asc')->get(),
            'intent' => $intent
        ]);
    }

    public function store(Request $request) {


        foreach($request->input() as $key => $value) {
           if ($key !== "_token" && $key !== "file" && $key!="card-button") {
               UserCharity::create([
                   'user_id' => Auth::id(),
                   'charity_id' => $value
               ]);
           }
        }

        return redirect()->route('dashboard');
    }
}
