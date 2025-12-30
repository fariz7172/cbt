<?php

namespace App\Providers;

use App\Models\Ujian;
use App\Models\Soal;
use App\Policies\UjianPolicy;
use App\Policies\SoalPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Ujian::class => UjianPolicy::class,
        Soal::class => SoalPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
