<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\Contracts\AuthorizationContract;
use Modules\Authorization\Managers\PermissionManager;
use Modules\Authorization\Managers\RoleManager;
use Modules\Authorization\Services\AuthorizationService;

class AuthorizationSeeder extends Seeder
{
    /**
     * @var AuthorizationService
     */
    protected $service;

    /**
     * AuthorizationSeeder constructor.
     *
     * @param $service
     */
    public function __construct(AuthorizationContract $service)
    {
        $this->service = $service;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->service->clearPermissionCache();
        $this->createPermissions();
        $this->createRoles();
    }

    protected function createPermissions(): void
    {
        $permissions = PermissionManager::getAllPermissions();
        $this->service->createPermissions(collect($permissions)->flatten()->toArray());
    }

    protected function createRoles(): void
    {
        foreach (RoleManager::ROLES as $role) {
            $this->service->createRole(strtolower($role::getRoleName()), $role::getPermissions());
        }
    }
}
