<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureVendorApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !$user->vendor) {
            return $next($request);
        }

        $vendor = $user->vendor;

        if (!$vendor->is_approved) {
            if (
                $request->routeIs('dashboard.index') ||
                $request->routeIs('profile.*')
            ) {
                return $next($request);
            }

            return redirect()->route('dashboard.index')->withErrors('Your vendor account is pending approval.');
        }

        return $next($request);
    }
}
