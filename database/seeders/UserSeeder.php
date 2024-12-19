<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //permissions
        $create = Permission::create(['name' => 'create']);
        $list = Permission::create(['name' => 'list']);
        $update = Permission::create(['name' => 'update']);
        $view = Permission::create(['name' => 'view']);
        $delete = Permission::create(['name' => 'delete']);

        //roles
        $admin_role = Role::create(['name' => 'admin']);
        $user_role = Role::create(['name' => 'user']);
        $guest_role = Role::create(['name' => 'guest']);

        //assign permissions to roles
        $admin_role->givePermissionTo([
            $create,
            $list,
            $update,
            $view,
            $delete,
        ]);
        $user_role->givePermissionTo([
            $create,
            $list,
            $update,
            $view,
        ]);
        $guest_role->givePermissionTo([
            $create,
            $update,
            $view,
        ]);

        //create a user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@system.me',
            'password' => bcrypt('Admin@123'),
        ]);
        $admin->assignRole($admin_role);
        $admin->givePermissionTo(Permission::all());

        //create a guest user
        $user = User::create([
            'name' => 'User',
            'email' => 'user@normal.me',
            'password' => bcrypt('User@123'),
        ]);
        $user->assignRole($user_role);
        $user->givePermissionTo([
            $create,
            $list,
            $update,
        ]);
    }
}
