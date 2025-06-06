<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

use App\Models\{User, Setores, Partidos, Vereadores};
use App\Policies\{UserPolicy, PartidosPolicy, SetoresPolicy, VereadoresPolicy};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configura o uso do Bootstrap 5 na paginação
        Paginator::useBootstrapFive();

        // Registro manual das policies
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Partidos::class, PartidosPolicy::class);
        Gate::policy(Setores::class, SetoresPolicy::class);
        Gate::policy(Vereadores::class, VereadoresPolicy::class);
    }
}
