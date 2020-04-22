<?php


namespace App\Helpers;

use App\Models\Account;
use App\Models\Transfer;
use App\User;
use Illuminate\Support\Facades\Auth;

trait Stripe
{
  public function getBalance(string $userid)
  {
      \Stripe\Stripe::setApiKey(config('stripe.api_key'));
      $stripe_id=Account::where('user_id', $userid)->value('stripe_user_id');
      $balance = \Stripe\Balance::retrieve([
         ['stripe_account' => $stripe_id]
      ]);
      return head($balance->toArray()['available'])['amount'];
  }

  Public function createStripeCustomer(string $userid,string $stripeId,string $email)
  {
      \Stripe\Stripe::setApiKey(config('stripe.api_key'));
      $customer = \Stripe\Customer::create([
          'email' => $email,
           'source' => 'tok_mastercard']);

      return $customer->id;
  }

  //need to be called when user adds a new card
    Public function createPaymentMethod(string $userid,string $cardNumber, string $exp_month, string $exp_year, string $cvc)
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));
        $paymentMethod= \Stripe\PaymentMethod::create([
               'type' => 'card',
               'card' => [
                   'number' => $cardNumber,
                   'exp_month' => $exp_month,
                   'exp_year' => $exp_year,
                   'cvc' => $cvc,
               ],
           ]);

        $stripe_id=Account::where('user_id', $userid)->pluck('stripe_customer_id');
        $customer= \Stripe\Customer::retrieve($stripe_id);

        //Attach the payment method to the stripe customer
         $paymentMethod->attach([
                 'customer' => $customer
             ]);
    }

   //Create PaymentIntent
    Public static function createPaymentIntent(int $tranferamount,string $userid)
    {
        $sending_user = Account::where('User_id',  $userid)->pluck('stripe_user_id');
        $transfergroup=$sending_user;
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));
         $paymentIntent = \Stripe\PaymentIntent::create([
            'payment_method_types' => ['card'],
            'amount' => ($tranferamount),
            'currency' => 'gbp',
            'transfer_group'=> $transfergroup,
            'transfer_data' => [
                'destination' => $sending_user
            ]
        ]);

        $paymentIntent->confirm([
            'payment_method' => 'pm_card_visa',
        ]);
        return $paymentIntent->id;
    }
    //Raise the transfer
    public static function createTransfer(int $amount,string $userid)
    {
        $stripe_user_id = Account::where('User_id',  $userid)->pluck('stripe_user_id');
        $transfergroup = $stripe_user_id;

        \Stripe\Stripe::setApiKey(config('stripe.api_key'));
        $transfer = \Stripe\Transfer::create([
            'amount' => 1,
            'currency' => 'gbp',
            'destination' => $stripe_user_id,
            'transfer_group' => $transfergroup
        ]);

       }

    //Tansfers the amount to platform account
    public static function createTransfertoPlatform(int $amount,string $userid)
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));
        $sending_user = Account::where('User_id',  $userid)->pluck('stripe_user_id');
        $transfergroup=$sending_user;

        $platformaccount = \Stripe\Account::retrieve();

        \Stripe\Stripe::setApiKey(config('stripe.api_key'));

        \Stripe\Transfer::create([
            'amount' => $amount,
            'currency' => 'gbp',
            'transfer_group' => $transfergroup,
            'destination' => 'acct_1GUtkWFr4BzKbeoH',
        ],
            ['stripe_account' => $sending_user]
            );
    }


    public static function listAllCards(string $userid)
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));

        $stripe_user_id =  Account::where('User_id',$userid)->pluck('stripe_customer_id');

        //List all the customers cards stored in Stripe
        $cards=\Stripe\Customer::allSources(
            $stripe_user_id ,
            ['object' => 'card', 'limit' => 3]
        );
    return $cards;
    }

    public static function cancelPaymentIntent(string $tranferId)
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));
        $stripe_payment_intent=Transfer::where('id', $tranferId)->pluck('stripe_payment_intent');

        $payment_intent = \Stripe\PaymentIntent::retrieve(
            $stripe_payment_intent
        );
        $payment_intent->cancel();
        return $payment_intent->status;
    }

    //Refund



}