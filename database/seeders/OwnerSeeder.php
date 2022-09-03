<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Owner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'Owner')->first();
        $user = User::create([
            'username' => 'Owner',
            'password' => bcrypt('12345678'),
            'role_id' => $role->id,
            'image' => 'assets/media/users/default.png',
        ]);

        Owner::create([
            'user_id' => $user->id,
            'name' => 'Owner',
            'place_of_birth' => 'Denpasar',
            'date_of_birth' => '1998/12/15',
            'gender' => true,
            'phone' => '082237188923',
            'address' => 'Jl. Palapa XIV Gg. Ikan Sardin No.9'
        ]);
    }
}
