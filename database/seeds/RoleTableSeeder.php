<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'A Admin Role';
        $role_admin->save();

        $role_staff = new Role();
        $role_staff->name = 'staff';
        $role_staff->description = 'A Staff Role';
        $role_staff->save();
    }
}
