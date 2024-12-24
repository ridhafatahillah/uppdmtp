<?php

namespace App\Providers;

use Carbon\Carbon;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('mobile', function () {
            return "<?php if (Agent::isMobile()): ?>";
        });

        Blade::directive('endmobile', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('desktop', function () {
            return "<?php if (!Agent::isMobile()): ?>";
        });

        Blade::directive('enddesktop', function () {
            return "<?php endif; ?>";
        });
        Carbon::setLocale('id');
    }

    public function register()
    {
        //
    }
}
