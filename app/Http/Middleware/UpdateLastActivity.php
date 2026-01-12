<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Update only if it hasn't been updated recently (e.g., in the last minute) to reduce DB writes
            // However, the requirement is just to track it. Let's update it.
            // Using forceFill to ensure it saves even if not in fillable (though we added it)
            // and using saveQuietly if we wanted to avoid events, but regular save is fine.
            $user->forceFill([
                'last_activity_at' => now(),
            ])->save();
        }

        return $next($request);
    }
}
