<?php

namespace App\Console\Commands;

use App\Mail\ReviewReminderMail;
use App\Models\ReviewContractor;
use App\Models\ReviewSubContractor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendReviewReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-review-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Process SubContractor Reviews
        $this->processReminders(ReviewSubContractor::class);

        // Process Contractor Reviews
        $this->processReminders(ReviewContractor::class);
    }

    protected function processReminders($model)
    {

        $userType = null;

        if (Auth::guard('contractor')->check()) {
            $userType = 'contractor';
        } elseif (Auth::guard('subcontractor')->check()) {
            $userType = 'subcontractor';
        }

        $records = $model::whereNotNull('completion_estimate')
            ->whereNull('completion_estimate_checked_at')
            ->whereIn('completion_estimate', [7, 30, 90])
            ->get();

        foreach ($records as $record) {
            $daysToWait = (int) $record->completion_estimate;
            $targetDate = $record->created_at->copy()->addDays($daysToWait);

            if ($targetDate->isToday()) {
                Mail::to($record->user->email)->send(new ReviewReminderMail($record, $userType));
                $record->completion_estimate_checked_at = now();
                $record->save();
            }
        }
    }
}
