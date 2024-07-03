<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('1234567890'),
            'gender' => 'Laki-laki',
            'date_of_birth' => '2002-02-02',
            'work' => 'Admin',
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('1234567890'),
            'gender' => 'Laki-laki',
            'date_of_birth' => '2002-02-02',
            'work' => 'Mahasiswa',
        ]);

        $user->assignRole('user');
    }
}
