<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 13.10.18
 * Time: 19:08.
 */

namespace Modules\Auth0\Drivers;

use Foundation\Exceptions\NotImplementedException;
use Illuminate\Validation\UnauthorizedException;
use Modules\Auth0\Abstracts\Auth0IdentityProviderTransformer;
use Modules\Auth0\Abstracts\Auth0ProfileValidator;
use Modules\Auth0\Transformers\Auth0DatabaseProfileTransformer;
use Modules\Auth0\Transformers\Auth0FacebookProfileTransformer;
use Modules\Auth0\Transformers\Auth0GoogleProfileTransformer;
use Modules\Auth0\Validators\Auth0DatabaseProfileValidator;
use Modules\Auth0\Validators\Auth0FacebookProfileValidator;
use Modules\Auth0\Validators\Auth0GoogleProfileValidator;
use Modules\User\Entities\User;

class Auth0UserProfileStorageDriver
{
    /**
     * @var \stdClass
     */
    protected $profile;
    /**
     * @var User
     */
    protected $user;
    /**
     * @var string
     */
    protected $identityProvider;

    /**
     * @var array
     */
    protected $requiredProfileAttributes = [
        'email',
        'name',
        'avatar',
    ];

    /**
     * @var Auth0IdentityProviderTransformer
     */
    protected $transformer;

    /**
     * @var Auth0ProfileValidator
     */
    protected $validator;

    /**
     * Auth0UserStorageDriver constructor.
     *
     * @param $profile
     * @param $user
     * @param $identityProvider
     */
    public function __construct(User $user, \stdClass $profile, string $identityProvider)
    {
        $this->profile = $profile;
        $this->user = $user;
        $this->identityProvider = $identityProvider;
        $this->boot();
    }

    /**
     * @throws NotImplementedException | UnauthorizedException
     */
    protected function boot()
    {
        $this->loadServices();

        if (! $this->validator->validate($this->profile)) {
            throw new UnauthorizedException('Invalid profile data found in the access token');
        }
    }

    /**
     * @throws NotImplementedException
     *
     * @return void
     */
    protected function loadServices()
    {
        switch ($this->identityProvider) {
            case 'auth0':
                $this->transformer = new Auth0DatabaseProfileTransformer();
                $this->validator = new Auth0DatabaseProfileValidator();
                break;
            case 'facebook':
                $this->transformer = new Auth0FacebookProfileTransformer();
                $this->validator = new Auth0FacebookProfileValidator();
                break;
            case 'google-oauth2':
                $this->transformer = new Auth0GoogleProfileTransformer();
                $this->validator = new Auth0GoogleProfileValidator();
                break;
            default:
                throw new NotImplementedException('Unsupported identity provider');
        }
    }

    public function run()
    {
        $profile = $this->transformer->transformProfile($this->profile);

        if ($this->profileHasChanged()) {
            $profile['provider'] = $this->identityProvider;
            $this->user->fill($profile);
            $this->user->save();
        }

        return $this->user;
    }

    protected function profileHasChanged(): bool
    {
        $user = $this->user->toArray();
        $profile = (array) $this->profile;

        return ! array_is_subset_of($profile, $user);
    }
}
