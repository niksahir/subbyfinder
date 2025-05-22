<?php

namespace App\Console\Commands;

use App\Models\Contractor;
use App\Models\UserSubscription;
use Illuminate\Console\Command;
use App\Models\SubContractor;
use App\Notifications\SubscriptionExpiredNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotifyExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:notify-expired';
    protected $description = 'Notify subcontractors whose subscriptions have expired';

    public function handle()
    {
        $expiredSubscriptions = UserSubscription::where('end_date', '<', Carbon::now())->where('notified_at' , null)->get();

        foreach ($expiredSubscriptions as $subscription) {
            $user = null;

            if ($subscription->user_type === 'contractor') {
                $user = Contractor::find($subscription->user_id);
            } elseif ($subscription->user_type === 'subcontractor') {
                $user = SubContractor::find($subscription->user_id);
            }

            if ($user) {
                $user->notify(new SubscriptionExpiredNotification($subscription, $user));
                $subscription->notified_at = Carbon::now();
                $subscription->save();

                Log::info("Subscription expired for {$subscription->user_type} ID {$user->id}, Email: {$user->email}, Expired At: {$subscription->ends_at}");
            } else {
                Log::warning("Subscription ID {$subscription->id} has invalid user or missing user.");
            }
        }
    }
}
