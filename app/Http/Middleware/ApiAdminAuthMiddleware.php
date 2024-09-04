<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!Auth::guard('admin_guard')->user() || Auth::guard('admin_guard')->user()->active!=1) {
                return response()->json(['status' => 301, 'message' => "You are not authorized !"]);
            }
        } catch (Exception $err) {
            return response()->json(['status' => 301, 'message' => "Server error at authentication !"]);
        }
        return $next($request);
    }
}
