<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Model\Role;
use App\Model\Permission;
use App\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('role_user')->truncate();
        DB::table('permission_role')->truncate();
        Permission::truncate();
        Role::truncate();
        DB::statement("SET foreign_key_checks=1");
        //create admin
        $userAdmin = User::create([
            'name' => 'rodolfo',
            'surname' => 'molina',
            'email' => 'santiago66jm@gmail.com',
            'password' => Hash::make('password'),
            'image' => 'hola'
        ]);
        $rolAdmin = Role::create([
            'name' => 'adminTo',
        ]);

        $userAdmin->roles()->sync([$rolAdmin->id]);
        //star
        $permission_all = [];
        $permission = Permission::create([
            'name' => 'create user',

        ]);
        $permission_all[] = $permission->id;
        $permission = Permission::create([
            'name' => 'edit user',

        ]);
        $permission_all[] = $permission->id;
        $permission = Permission::create([
            'name' => 'bloquear user',

        ]);
        $permission_all[] = $permission->id;
        $permission = Permission::create([
            'name' => 'desbloquear user',

        ]);
        $permission_all[] = $permission->id;
        $permission = Permission::create([
            'name' => 'view user',

        ]);
        $permission_all[] = $permission->id;
        $permission = Permission::create([
            'name' => 'create rol',

        ]);
        $permission_all[] = $permission->id;
        $permission = Permission::create([
            'name' => 'view rol',

        ]);
        $permission_all[] = $permission->id;
        $permission = Permission::create([
            'name' => 'edit rol',

        ]);
        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name' => 'create permission',

        ]);
        $permission_all[] = $permission->id;
        $permission = Permission::create([
            'name' => 'view permission',

        ]);
        $permission_all[] = $permission->id;
        $permission = Permission::create([
            'name' => 'edit permission',

        ]);
        $permission_all[] = $permission->id;
        $rolAdmin->permissions()->sync($permission_all);
        //end
    }
}