<?php

namespace Modules\Auth0\Middleware;

use Auth0\Login\Contract\Auth0UserRepository;
use Auth0\SDK\Exception\CoreException;
use Auth0\SDK\Exception\InvalidTokenException;
use Closure;
use Foundation\Abstracts\Middleware\Middleware;
use Illuminate\Http\Request;

class Auth0AuthenticationMiddleware extends Middleware
{
    protected $auth0Service;

    /**
     * Auth0AuthenticationMiddleware constructor.
     */
    public function __construct(Auth0UserRepository $auth0Service)
    {
        $this->auth0Service = $auth0Service;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $auth0 = \App::make('auth0');

        $accessToken = $request->bearerToken();

        try {
            $tokenInfo = $auth0->decodeJWT($accessToken);
            $user = $this->auth0Service->getUserByDecodedJWT($tokenInfo);

            if (! $user) {
                return response()->json(['error' => 'Unauthorized user.'], 401);
            }

            \Auth::login($user);
        } catch (InvalidTokenException $e) {
            return response()->json(['error' => 'Invalid or no token set.'], 401);
        } catch (CoreException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
