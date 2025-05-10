<?php

namespace App\Providers;

use App\Models\ContractorProject;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Contractor;
use App\Models\SubContractor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'subcontractor' => SubContractor::class,
            'contractor' => Contractor::class,
        ]);

        Relation::morphMap([
            'contractor_project' => ContractorProject::class,
            'subcontractor_project' => SubContractor::class,
        ]);
    }
}
