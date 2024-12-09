<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Facades\Agent;

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
    }

    public function register()
    {
        //
    }
}
