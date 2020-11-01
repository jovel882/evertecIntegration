<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::create(['name' => 'SuperAdministrator']);

        Role::create(['name' => 'Ordenes'])
            ->givePermissionTo(Permission::where('name', 'like', 'Orders%')
            ->get()
            );
    }
}
