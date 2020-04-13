<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;
use Closure;

class Authenticate // extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    private function authenticate($request, $guards)
    {
        if ($request->user() === null) {
            throw new AuthenticationException(
                'Unauthenticated.', $guards, route('login')
            );
        }
    }
}
