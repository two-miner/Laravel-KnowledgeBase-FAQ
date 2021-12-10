<?php

namespace App\Http\Middleware;

use App\Helper\SessionUnlock;
use Closure;

class Unlocked
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
        if (!(new SessionUnlock($request->session()))->isUnlocked()) {
            return redirect()->guest(route('password'));
        }

        return $next($request);
    }
}
