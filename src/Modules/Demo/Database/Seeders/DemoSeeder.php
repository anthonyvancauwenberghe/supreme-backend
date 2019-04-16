<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 28.10.18
 * Time: 16:15.
 */

namespace Modules\Demo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Account\Entities\Account;
use Modules\Auth0\Contracts\Auth0ServiceContract;
use Modules\Auth0\Services\Auth0Service;
use Modules\Auth0\Traits\Auth0TestUser;
use Modules\Authorization\Entities\Role;
use Modules\Machine\Entities\Machine;
use Modules\Proxy\Entities\Proxy;

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
        $this->seedMachines($user);
        $this->seedProxies($user);
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

    /**
     * @param $user
     * @return mixed
     */
    protected function seedMachines($user)
    {
        $machines = Machine::fromFactory(10)
            ->create([
                'user_id' => $user->id,
            ]);

        foreach ($machines as $machine) {
            $this->seedAccounts($machine);
        }

        return $machines;
    }

    protected function seedProxies($user)
    {
        $proxies = Proxy::fromFactory(30)
            ->create([
                'user_id' => $user->id,
            ]);

        foreach ($proxies as $proxy) {
            $this->seedAccounts($proxy);
        }

        return $proxy;
    }

    /**
     * @param $machine
     * @return mixed
     */
    protected function seedAccounts($machine)
    {
        $accounts = Account::fromFactory(10)
            ->state('OSRS')
            ->create([
                'user_id' => $machine->user_id,
                'machine_id' => $machine->id,
            ]);

        return $accounts;
    }
}
