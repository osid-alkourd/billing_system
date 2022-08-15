<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $user = User::create([
            'name' => 'osid alkourd',
            'email' => 'alkordosid73@gmail.com',
            'password' => bcrypt('osidosid'),
            'roles_name' => ["owner"],
            'Status' => 'active',
        ]);
        

/*
        $user2 = User::create([
            'name' => 'mohab alkourd',
            'email' => 'alkordmohab73@gmail.com',
            'password' => bcrypt('osidosid'),
            'roles_name' => ["super-admin"],
            'Status' => 'active',
        ]);
        */

        $role = Role::create(['name' => 'owner']);

        $permissions = Permission::pluck('id','id')->all(); // all permissions

        $role->syncPermissions($permissions); // assign all permissions to this role

       $user->assignRole([$role->id]); //assign this user to owner role
       // $user2->assignRole([$role->id]);

    }

}
