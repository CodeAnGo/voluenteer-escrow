<?php
/**
 * Created by PhpStorm.
 * User: lurob
 * Date: 2020-04-28
 * Time: 11:10
 */

namespace App\Repositories\Interfaces;


use App\Models\Transfer;
use App\User;

interface StripeServiceRepositoryInterface
{
    public function createTransfer(Transfer $transfer);

    public function getAccountFromUser(User $user);

    public function getCustomerFromUser(User $user);

    public function createCustomerFromUser(User $user);

    public function createSetupIntentFromCustomer($customer_id);

    public function getDefaultPaymentMethodForCustomer($customer_id);

    public function createPaymentIntentFromUser(User $user, $amount, $currency='gbp');

    public function capturePaymentFromPaymentIntent($payment_intent_id);

    public function convertToStripeAmount($amount);

    public function cancelPaymentFromPaymentIntent($payment_intent_id);

    public function confirmPaymentFromPaymentIntent($payment_intent_id);

    public function refundFullPaymentFromPaymentIntent($payment_intent_id);

    public function refundPartialPaymentFromPaymentIntent($payment_intent_id, $refund_amount);

    public function getBalanceTransactionFromTransfer(Transfer $transfer);
}