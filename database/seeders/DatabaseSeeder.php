<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'user_id' => 'Admin1',
            'nama' => 'Hafidz',
            'password' => Hash::make('1'), // Gantilah 'password' dengan password yang diinginkan
            'level' => 'Administrator',
            'alamat' => 'Gresik',
            'telp' => '089612684096',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


    }
}
