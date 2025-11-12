<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebSetting;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        $setting = WebSetting::where('key', 'maintenance_mode')->first();
        $maintenance = filter_var($setting?->value, FILTER_VALIDATE_BOOLEAN);
        $admin = User::whereHas('admin')->where('id', Auth::id())->first();

        if ($maintenance && (!Auth::check() || !$admin)) {
            return response()->view('custom.maintenance');
        }

        return $next($request);
    }
}