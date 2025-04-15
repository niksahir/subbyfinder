<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            // Basic
            [
                'name' => 'Basic Plan',
                'plan_key' => 'basic_monthly',
                'price' => 15,
                'billing_type' => 'monthly',
                'features' => json_encode([
                    '2 Business Contact unlocks per month',
                    '2 images on profile',
                    'No Job Postings',
                ]),
            ],
            [
                'name' => 'Basic Plan',
                'plan_key' => 'basic_yearly',
                'price' => 129,
                'billing_type' => 'yearly',
                'features' => json_encode([
                    '2 Business Contact unlocks per month',
                    '2 images on profile',
                    'No Job Postings',
                ]),
            ],

            // Premium
            [
                'name' => 'Premium Plan',
                'plan_key' => 'premium_monthly',
                'price' => 29,
                'billing_type' => 'monthly',
                'features' => json_encode([
                    '5 Business Contact unlocks per month',
                    '3 Job Postings Per Month',
                    '3 Images on Profile',
                ]),
            ],
            [
                'name' => 'Premium Plan',
                'plan_key' => 'premium_yearly',
                'price' => 249,
                'billing_type' => 'yearly',
                'features' => json_encode([
                    '5 Business Contact unlocks per month',
                    '3 Job Postings Per Month',
                    '3 Images on Profile',
                ]),
            ],

            // Enterprise
            [
                'name' => 'Enterprise Plan',
                'plan_key' => 'enterprise_monthly',
                'price' => 59,
                'billing_type' => 'monthly',
                'features' => json_encode([
                    'Unlimited Contacts & Job Posting',
                    'Option to have Listing in Both Principal and Sub Contractors',
                    'Showcase of projects and work',
                ]),
            ],
            [
                'name' => 'Enterprise Plan',
                'plan_key' => 'enterprise_yearly',
                'price' => 399,
                'billing_type' => 'yearly',
                'features' => json_encode([
                    'Unlimited Contacts & Job Posting',
                    'Option to have Listing in Both Principal and Sub Contractors',
                    'Showcase of projects and work',
                ]),
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['plan_key' => $plan['plan_key']], $plan);
        }
    }
}
