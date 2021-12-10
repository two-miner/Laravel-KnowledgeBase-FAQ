<?php

namespace App\Http\Middleware;

use App\Helper\SessionUnlock;
use App\Http\Controllers\Auth\PasswordController;
use Closure;

class RedirectIfUnlocked
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
        if ((new SessionUnlock($request->session()))->isUnlocked()) {
            return redirect(PasswordController::REDIRECT_TO);
        }

        return $next($request);
    }
}
