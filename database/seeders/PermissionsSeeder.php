<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::insert([
            [
                'name' => 'orders',
                'guard_name' => 'web'
            ],
            [
                'name' => 'orders.create',
                'guard_name' => 'web'
            ],
            [
                'name' => 'orders.update',
                'guard_name' => 'web'
            ],
            [
                'name' => 'orders.view',
                'guard_name' => 'web'
            ],
            [
                'name' => 'orders.viewAny',
                'guard_name' => 'web'
            ],
            [
                'name' => 'orders.delete',
                'guard_name' => 'web'
            ],
            [
                'name' => 'orders.trash',
                'guard_name' => 'web'
            ],
            [
                'name' => 'orders.forceDelete',
                'guard_name' => 'web'
            ],
            [
                'name' => 'orders.restore',
                'guard_name' => 'web'
            ]
        ]);
    }
}
