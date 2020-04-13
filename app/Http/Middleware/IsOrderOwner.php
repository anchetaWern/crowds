<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsOrderOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->order->user_id != Auth::id()) {
            abort(401, "You didn't create the order.");
        }

        return $next($request);
    }
}
