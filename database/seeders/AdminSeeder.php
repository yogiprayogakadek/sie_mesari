<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'Admin')->first();
        $user = User::create([
            'username' => 'admin',
            'password' => bcrypt('12345678'),
            'role_id' => $role->id,
            'image' => 'assets/media/users/default.png',
        ]);

        Admin::create([
            'user_id' => $user->id,
            'name' => 'Administrator',
            'place_of_birth' => 'Denpasar',
            'date_of_birth' => '1998/12/15',
            'gender' => true,
            'phone' => '082237188923',
            'address' => 'Jl. Palapa XIV Gg. Ikan Sardin No.9',
            'is_active' => true
        ]);
    }
}
