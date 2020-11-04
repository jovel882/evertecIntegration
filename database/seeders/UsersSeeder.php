<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@evertec.com',
            'phone' => '+5713795628',
            'password' => bcrypt('password'),
        ])->assignRole('SuperAdministrator');
        User::create([
            'name' => 'Admin Ordenes',
            'email' => 'admin_ordenes@evertec.com',
            'phone' => '+5713795628',
            'password' => bcrypt('password'),
        ])->assignRole('Orders');
        User::create([
            'name' => 'John Fredy Velasco Bareño',
            'email' => 'jovel882@gmail.com',
            'phone' => '+573202919054',
            'password' => bcrypt('123456789'),
        ]);
    }
}
