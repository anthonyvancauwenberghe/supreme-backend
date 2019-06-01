<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 28.10.18
 * Time: 16:15.
 */

namespace Modules\Demo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth0\Contracts\Auth0ServiceContract;
use Modules\Auth0\Services\Auth0Service;
use Modules\Auth0\Traits\Auth0TestUser;
use Modules\Authorization\Entities\Role;

class DemoSeeder extends Seeder
{
    use Auth0TestUser;

    /**
     * @var bool
     */
    public $enabled = false;

    /**
     * @var Auth0Service
     */
    public $service;

    /**
     * DemoSeeder constructor.
     *
     * @param bool $seed
     */
    public function __construct(Auth0ServiceContract $auth0Service)
    {
        $this->service = $auth0Service;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = $this->seedUser();
    }

    /**
     * @return mixed
     */
    protected function seedUser()
    {
        $user = $this->getTestUser();
        $user->syncRoles(Role::ADMIN);

        return $user;
    }
}
