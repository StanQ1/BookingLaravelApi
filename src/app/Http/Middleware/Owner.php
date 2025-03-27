<?php

namespace App\Http\Middleware;

use App\UserRoles;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Owner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->guard('sanctum')->user()['role'] == UserRoles::OWNER->value)
        {
            return $next($request);
        } else {
            return response('Permission denied! Bad role.', Response::HTTP_FORBIDDEN);
        }
    }
}
