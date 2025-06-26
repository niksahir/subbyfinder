<?php

namespace App\Http\Controllers;

use App\Mail\PurchasePlan;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Plan;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StripeController extends Controller
{

    public function showPlans()
    {
        $monthlyPlans = Plan::where('billing_type', 'monthly')->get();
        $yearlyPlans = Plan::where('billing_type', 'yearly')->get();

        return view('plans', compact('monthlyPlans', 'yearlyPlans'));
    }

    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $planKey = $request->plan_id;

        $plan = Plan::where('id', $planKey)->first();
        // Create a Stripe Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'aud',
                    'product_data' => [
                        'name' => $plan->name,
                    ],
                    'unit_amount' => $plan->price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'allow_promotion_codes' => true,
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
            'metadata' => [
                'plan_key' => $plan->plan_key, // make sure your Plan model has a unique plan_key
            ],
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        if (Auth::guard('contractor')->check()) {
            $user = Auth::guard('contractor')->user();
            $userType = 'contractor';
        } elseif (Auth::guard('subcontractor')->check()) {
            $user = Auth::guard('subcontractor')->user();
            $userType = 'subcontractor';
        } else {
            return redirect()->route('login');
        }

        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('plans')->with('error', 'Missing session ID.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            return redirect()->route('front.pricing')->with('error', 'Your Payment is Failed/Pending.');
        }

        // Optional: prevent double subscription for same session
        $existing = UserSubscription::where('user_id', $user->id)
            ->where('user_type', $userType)
            ->where('stripe_session_id', $session->id)
            ->first();

        if ($existing) {
             // already subscribed
             return view('stripe.success');
        }

        $plan = Plan::where('plan_key', $session->metadata['plan_key'])->first();

        if (!$plan) {
            return redirect()->route('plans')->with('error', 'Plan not found.');
        }

        UserSubscription::create([
            'user_id' => $user->id,
            'user_type' => $userType,
            'plan_id' => $plan->id,
            'start_date' => now(),
            'end_date' => now()->addMonths($plan->billing_type === 'monthly' ? 1 : 12),
            'is_active' => true,
            'stripe_session_id' => $session->id,
        ]);

        $UserSubscription = UserSubscription::where('user_id', $user->id)
            ->where('user_type', $userType)
            ->where('stripe_session_id', $session->id)
            ->with('plan')
            ->first();
        // if($userType == 'contractor'){
        //     return redirect()->route('contractor.dashboard.index')->with('success', 'Subscription successful!');
        // } else {
        //     return redirect()->route('subcontractor.dashboard.index')->with('success', 'Subscription successful!');
        // }

        Mail::to($user->email)->send(new PurchasePlan($user->contact_name,$plan->name,$plan->billing_type,$plan->price,$UserSubscription->start_date,$UserSubscription->end_date,$userType));

        return view('stripe.success',compact('UserSubscription','userType'));
    }

    public function cancel()
    {
        return view('stripe.cancel');
    }
}
