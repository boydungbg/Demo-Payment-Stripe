<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Account;
use Stripe\AccountLink;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{
    protected $stripe;
    public function __construct()
    {
        $this->stripe = Stripe::setApiKey("sk_test_51HgRrLBAfYK2yM8zfuWXRh117trEbXiKyNdgvi4kFSPk9QEIKTH3kqdhJTSwS5i1oTMjq72bj3NFcnV1Ht8zKqlT00SJDjVojm");
    }
    public function createAccount(Request $req)
    {
        $account = Account::create([
            'type' => 'express',
            'country' => 'US',
        ]);
        $accountLink = AccountLink::create([
            'account' => $account["id"],
            'refresh_url' => 'http://localhost:8000/reauth/' . $account["id"],
            'return_url' => 'http://localhost:8000/return/' . $account["id"],
            'type' => 'account_onboarding',
        ]);
        dd($accountLink);
    }
    public function getInforAccountCreate(Request $req, $id)
    {
        Account::retrieve($id);
    }
    public function createPaymentInten(Request $req)
    {
        PaymentIntent::create([
            'amount' => $req->price,
            'confirm' => true,
            'payment_method' => $req->id,
            'description' => "test cai nay no cu kieu gi y",
            "currency" => "USD",
            'transfer_data' => [
                'destination' => 'acct_1HhXzLK0C7pS9I9l',
            ],
        ]);
    }
}
