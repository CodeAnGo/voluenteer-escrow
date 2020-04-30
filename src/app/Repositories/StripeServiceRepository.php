<?php
/**
 * Created by PhpStorm.
 * User: lurob
 * Date: 2020-04-28
 * Time: 11:11
 */

namespace App\Repositories;


use App\Models\Account;
use App\Models\Transfer;
use App\Repositories\Interfaces\StripeServiceRepositoryInterface;
use App\User;
use Ramsey\Uuid\Uuid;
use Stripe\BalanceTransaction;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Person;
use Stripe\Refund;
use Stripe\SetupIntent;

class StripeServiceRepository implements StripeServiceRepositoryInterface
{
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_key'));
    }

    public function getAccountFromUser(User $user)
    {
        return \Stripe\Account::retrieve($user->account->stripe_user_id);
    }

    public function getChargeFromTransfer(Transfer $transfer){
        return head(PaymentIntent::retrieve($transfer->stripe_payment_intent)->charges->data);
    }

    public function createTransfer(Transfer $transfer)
    {
        $receiving_party = User::where('id', $transfer->receiving_party_id)->first();
        $source_charge = $this->getChargeFromTransfer($transfer);
        $transfer_amount = $transfer->actual_amount < $transfer->transfer_amount ? $transfer->actual_amount : $transfer->transfer_amount;
        $transferActual =  \Stripe\Transfer::create([
            'amount' => $this->convertToStripeAmount($transfer_amount),
            'currency' => 'gbp',
            'destination' => $receiving_party->account->stripe_user_id,
            'source_transaction' => $source_charge->id,
            'transfer_group' => $transfer->transfer_group
        ]);
        $transfer->stripe_transfer_id = $transferActual->id;
        $transfer->save();
        return $transferActual;
    }

    public function updateCardPaymentsCapability($user){
//        $account = $user->account;
//        \Stripe\Account::updateCapability(
//            $account->stripe_user_id,
//            'card_payments',
//            ['requested' => true]
//        );
    }

    public function getCustomerFromUser(User $user)
    {
        $stripeAccount = Account::where('user_id', $user->id)->first();
        if ($stripeAccount->stripe_customer_id == null){
            return $this->createCustomerFromUser($user);
        }
        return $this->getCustomerFromCustomerId($stripeAccount->stripe_customer_id);
    }

    public function createCustomerFromUser(User $user)
    {
        $customer = Customer::create([
           'email' => $user->email,
           'name' => $user->name
        ]);

        $account = $user->account;
        $account->stripe_customer_id = $customer->id;
        $account->save();
        return $this->getCustomerFromCustomerId($customer->id);
    }

    private function getCustomerFromCustomerId($customer_id){
        return Customer::retrieve($customer_id);
    }

    public function createSetupIntentFromCustomer($customer_id)
    {
        return SetupIntent::create([
            'customer' => $customer_id
        ]);
    }

    public function getDefaultPaymentMethodForCustomer($customer_id){
        return head(PaymentMethod::all([
            'customer' => $customer_id,
            'type' => 'card',
        ])->data);
    }

    public function createPaymentIntentFromUser(User $user, $amount, $currency='gbp')
    {
        $customer = $this->getCustomerFromUser($user);
        return PaymentIntent::create([
            'amount' => $this->calculateStripeFee($amount),
            'currency' => $currency,
            'payment_method_types' => ['card'],
            'payment_method' => $this->getDefaultPaymentMethodForCustomer($customer->id)->id,
            'capture_method' => 'manual',
            'transfer_group' => Uuid::uuid4(),
            'confirm' => 'false',
            'customer' => $customer->id,
            'on_behalf_of' => $user->account->stripe_user_id
        ]);
    }

    public function capturePaymentFromPaymentIntent($payment_intent_id){
        return PaymentIntent::retrieve($payment_intent_id)->capture();
    }

    public function cancelPaymentFromPaymentIntent($payment_intent_id){
        return PaymentIntent::retrieve($payment_intent_id)->cancel();
    }

    public function confirmPaymentFromPaymentIntent($payment_intent_id){
        return PaymentIntent::retrieve($payment_intent_id)->confirm();
    }

    public function refundFullPaymentFromPaymentIntent($payment_intent_id){
        return Refund::create([
            'payment_intent' => $payment_intent_id
        ]);
    }

    public function refundPartialPaymentFromPaymentIntent($payment_intent_id, $refund_amount){
        return Refund::create([
            'payment_intent' => $payment_intent_id,
            'amount' => $refund_amount
        ]);
    }

    public function convertToStripeAmount($amount){
        return round($amount * 100);
    }

    public function calculateStripeFee($transfer_amount){
        $card_processing_fee = 0.5;
        $payment_processing_fee_percent = 2.7;
        $payment_processing_fee = ($payment_processing_fee_percent/100) * $transfer_amount;
        return $this->convertToStripeAmount($card_processing_fee + $transfer_amount + $payment_processing_fee);
    }

    public function getBalanceTransactionFromTransfer(Transfer $transfer)
    {
        $transferActual = \Stripe\Transfer::retrieve($transfer->stripe_transfer_id);
        if ($transferActual){
            return($transferActual->balance_transaction);
        }
    }
}