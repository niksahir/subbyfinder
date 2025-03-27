<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contractor;
use App\Models\Subcontractor;
use App\Models\ContractorProject;
use Illuminate\Support\Facades\Mail;

class SendProjectAlerts extends Command
{
    protected $signature = 'send:project-alerts';
    protected $description = 'Send latest projects to users with email alerts enabled';

    public function handle()
    {
        // Get latest 5 projects
        $projects = ContractorProject::orderBy('created_at', 'desc')->take(5)->get();

        // Send to contractors
        $contractors = Contractor::where('email_alerts', 1)->get();
        foreach ($contractors as $contractor) {
            Mail::send('emails.project_alert', ['projects' => $projects], function ($message) use ($contractor) {
                $message->to($contractor->email)
                    ->subject('Weekly Project Updates for Contractors');
            });
        }

        // Send to subcontractors
        $subcontractors = Subcontractor::where('email_alerts', 1)->get();
        foreach ($subcontractors as $subcontractor) {
            Mail::send('emails.project_alert', ['projects' => $projects], function ($message) use ($subcontractor) {
                $message->to($subcontractor->email)
                    ->subject('Weekly Project Updates for Subcontractors');
            });
        }

        $this->info('Project alerts sent successfully to contractors and subcontractors!');
    }
}
