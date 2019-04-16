<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 20:08.
 */

namespace Modules\Auth0\Traits;

use Cache;
use Foundation\Exceptions\Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Modules\Auth0\Contracts\Auth0ServiceContract;
use Modules\Auth0\Services\Auth0Service;
use Modules\User\Entities\User;

trait Auth0TestUser
{
    private function getAuth0Service() : Auth0Service
    {
        return once(function () {
            return app()->make(Auth0ServiceContract::class);
        });
    }

    private function getTestUser(): User
    {
        $auth0 = \App::make('auth0');
        $tokenInfo = $auth0->decodeJWT($this->getUserAuth0Token()->id_token);

        return $this->getAuth0Service()->getUserByDecodedJWT($tokenInfo);
    }

    private function getUserAuth0Token()
    {
        return Cache::remember('testing:http_access_token', 60 * 60, function () {
            try {
                $httpClient = new Client();
                $response = $httpClient->post(env('AUTH0_DOMAIN').'oauth/token', [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => env('AUTH0_CLIENT_ID'),
                        'username' => env('AUTH0_TEST_USER_NAME'),
                        'password' => env('AUTH0_TEST_USER_PASS'),
                        'scope' => 'openid profile email offline_access',
                    ],
                ]);

                return json_decode($response->getBody()->getContents());
            } catch (ClientException $exception) {
                throw new Exception('Could not obtain token from Auth0 at '.env('AUTH0_DOMAIN').' for testing.');
            }
        });
    }
}
