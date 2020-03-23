<?php

namespace Bambamboole\LaravelCms\Auth\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class Authenticate
{
    protected Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->auth->guard('web')->check()) {
            $this->auth->shouldUse('web');
        } else {
            throw new AuthenticationException(
                'Unauthenticated.', ['web'], route('cms.auth.login')
            );
        }

        return $next($request);
    }
}
