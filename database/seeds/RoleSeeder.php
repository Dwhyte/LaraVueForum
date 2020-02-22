<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'Administrator', 'guard_name' => 'api']);
        $memberRole = Role::firstOrCreate(['name' => 'Member', 'guard_name' => 'api']);
    }
}
