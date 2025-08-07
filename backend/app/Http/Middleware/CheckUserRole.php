<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
        /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            // Redirect to login or abort with unauthorized status
            return redirect()->route('admin.login'); // Or abort(401, 'Unauthorized.');
        }

        $user = auth()->user();

        // Ensure the User model uses your HasPermissionsAndRoles trait
        // You might want a more robust check here if not all models will have it
        // For simplicity, we'll assume it's on the User model.
        if (!in_array(\App\Traits\HasPermissionsAndRoles::class, class_uses($user))) {
            abort(500, 'You\'re not probihited');
        }

        // If no specific roles are passed to the middleware, allow access
        if (empty($roles)) {
            return $next($request);
        }

        // Check if the user has any of the required roles
        // Your trait's hasAnyRole method expects an array
        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }

        // If the user doesn't have the required role(s), abort with a 403 Forbidden error
        abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
