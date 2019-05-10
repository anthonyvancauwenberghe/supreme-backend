<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 13.10.18
 * Time: 20:50.
 */

namespace Modules\Auth0\Services;

use Auth0\Login\Repository\Auth0UserRepository;
use Modules\Auth0\Contracts\Auth0ServiceContract;
use Modules\Auth0\Drivers\Auth0UserProfileStorageDriver;
use Modules\User\Contracts\UserServiceContract;
use Modules\User\Events\UserRegisteredEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Auth0Service extends Auth0UserRepository implements Auth0ServiceContract
{
    protected $service;

    /**
     * Auth0UserRepository constructor.
     *
     * @param $service
     */
    public function __construct(UserServiceContract $service)
    {
        $this->service = $service;
    }

    /* This class is used on api authN to fetch the user based on the jwt.*/
    public function getUserByDecodedJWT($jwt)
    {
        /*
         * The `sub` claim in the token represents the subject of the token
         * and it is always the `user_id`
         */
        $jwt->user_id = $jwt->sub;

        return $this->upsertUser($jwt);
    }

    public function getUserByUserInfo($userInfo)
    {
        return $this->upsertUser($userInfo['profile']);
    }

    protected function upsertUser($profile)
    {
        if (! isset($profile->user_id)) {
            throw new BadRequestHttpException('Missing token information: Auth0 user id is not set');
        }
        $identifier = explode('|', $profile->user_id);
        $identityProvider = $identifier[0];
        $id = $identifier[1];

        $user = $this->service->findByIdentityId($id);
        if ($user === null) {
            $user = $this->service->newUser([
                'identity_id' => $id,
            ]);
        }
        $driver = new Auth0UserProfileStorageDriver($user, $profile, $identityProvider);
        $user = $driver->run();

        if ($user->wasRecentlyCreated) {
            event(new UserRegisteredEvent($user));
        }

        return $user;
    }
}
