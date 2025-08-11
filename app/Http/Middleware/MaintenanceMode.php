<?php

namespace App\Http\Middleware;

use App\Settings\SiteSettings;
use Closure;

class MaintenanceMode
{
    public function handle($request, Closure $next)
    {
        $siteSettings = app(SiteSettings::class); // atau cara lain get settings

        if (isset($siteSettings->is_maintenance) && $siteSettings->is_maintenance) {
            return redirect()->route('maintenance');
        }

        return $next($request);
    }
}
