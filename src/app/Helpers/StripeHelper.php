<?php


namespace App\Helpers;

use App\Models\Account;
use App\Models\Transfer;
use App\User;
use Illuminate\Support\Facades\Auth;

class StripeHelper
{
  public function getBalance($userid)
  {
      \Stripe\Stripe::setApiKey(config('stripe.api_key'));
      $stripe_id=Account::where('user_id', $userid)->value('stripe_user_id');
      $balance = \Stripe\Balance::retrieve([
         ['stripe_account' => $stripe_id]
      ]);
      return head($balance->toArray()['available'])['amount'];
  }

  Public static function createStripeCustomer( $email)
  {

      \Stripe\Stripe::setApiKey(config('stripe.api_key'));
      $customer = \Stripe\Customer::create([
          'email' => $email,
           'source' => 'tok_mastercard']);

      return $customer->id;
  }

  //need to be called when user adds a new card
    Public function createPaymentMethod( $userid, $cardNumber,  $exp_month,  $exp_year,  $cvc)
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

        $stripe_id=Account::where('user_id', $userid)->value('stripe_customer_id');
        $customer= \Stripe\Customer::retrieve($stripe_id);

        //Attach the payment method to the stripe customer
         $paymentMethod->attach([
                 'customer' => $customer
             ]);
    }

   //Create PaymentIntent
    Public static function createPaymentIntentToPlatfromAcount( $tranferamount, $userid)
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));

        $sending_user = Account::where('User_id',  $userid)->value('stripe_user_id');
        $stripe_customer_id = Account::where('User_id',  $userid)->value('stripe_customer_id');
        $platformaccount = \Stripe\Account::retrieve();

         $paymentIntent = \Stripe\PaymentIntent::create([
            'customer'=> $stripe_customer_id,
            //'payment_method'=>$paymentMethod->id,
            'payment_method_types' => ['card'],
            'amount' => ($tranferamount),
            'currency' => 'gbp',

         ]);
         return $paymentIntent->id;
    }

    public static function payoutVolunteer($amount,$stripe_customer_id)
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));
        $payout = \Stripe\Payout::create([
            'amount' => 1000,
            'currency' => 'gbp',
        ]
          /*  [
            'stripe_account' => 'acct_1GcZFdB7P393bdVq'
             ]*/
        );
    }
    Public static function confirmPaymentIntent($stripe_payment_intent)
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));
        $payment_intent = \Stripe\PaymentIntent::retrieve(
            $stripe_payment_intent
        );

        $payment_intent->confirm([
            'payment_method' => 'pm_card_visa',
        ]);
    }
    //Raise the transfer
    public static function createTransfer( $amount, $receivingUserid, $TransferGroup)
    {
        $stripe_user_id = Account::where('User_id',  $receivingUserid)->value('stripe_user_id');

        \Stripe\Stripe::setApiKey(config('stripe.api_key'));
        $transfer = \Stripe\Transfer::create([
            'amount' => $amount,
            'currency' => 'gbp',
            'destination' => $stripe_user_id,
            'transfer_group' => $TransferGroup
        ]);
       }

    //Tansfers the amount to platform account
    public static function createTransfertoPlatform( $amount, $senderUserid, $TransferGroup)
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));
        $sending_user = Account::where('User_id',  $senderUserid)->value('stripe_user_id');

        $platformaccount = \Stripe\Account::retrieve();

        \Stripe\Transfer::create([
            'amount' => $amount,
            'currency' => 'gbp',
            'destination' => $platformaccount,
            'transfer_group' => $TransferGroup
        ],
            ['stripe_account' => $sending_user]
            );
    }


    public static function listAllCards( $userid)
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));

        $stripe_user_id =  Account::where('User_id',$userid)->value('stripe_customer_id');

        //List all the customers cards stored in Stripe
        $cards=\Stripe\Customer::allSources(
            $stripe_user_id ,
            ['object' => 'card', 'limit' => 3]
        );
    return $cards;
    }

    public static function cancelPaymentIntent( $stripe_payment_intent )
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));


        $payment_intent = \Stripe\PaymentIntent::retrieve(
            $stripe_payment_intent
        );
        $payment_intent->cancel();
        return $payment_intent->status;
    }
    

    public static function refundCustomer($stripe_payment_intent, $transfer_amount, $partial = false)
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));

        $payment_intent = \Stripe\PaymentIntent::retrieve(
            $stripe_payment_intent
        );

        if ($payment_intent->status == 'succeeded' || $partial) {
            $refund = \Stripe\Refund::create([
                'payment_intent' => $stripe_payment_intent,
                'amount' => $transfer_amount
            ]);
        } else {
            self::cancelPaymentIntent($stripe_payment_intent);
        }
    }

}
