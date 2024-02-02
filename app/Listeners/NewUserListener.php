<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class NewUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct(User $user)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $roleSuperAdmin = Role::create(['name' => 'Super Admin']);
        $roleServerAdmin = Role::create(['name' => 'Server Admin']);
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleModerator = Role::create(['name' => 'Moderator']);
        $viewUsers = Permission::create(['name' => 'View Users']);
        $editUsers = Permission::create(['name' => 'Edit Users']);
        $viewServers = Permission::create(['name' => 'View Servers']);
        $editServers = Permission::create(['name' => 'Edit Servers']);

        $roleServerAdmin->givePermissionTo($viewUsers, $editUsers, $viewServers, $editServers);
        $roleAdmin->givePermissionTo($viewUsers, $viewServers, $editServers);
        $roleModerator->givePermissionTo($viewServers);
        User::first()->assignRole($roleSuperAdmin);
    }
}
