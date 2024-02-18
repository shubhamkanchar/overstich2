<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = User::where('email', 'admin@overstitch.com')->count();
        if ($count == 0) {
            $admin = User::create([
                'name' => 'admin',
                'email' => 'admin@overstitch.com',
                'password' => Hash::make('123456'),
                'user_type' => 'admin'
            ]);
            $admin->assignRole('admin');
        }
    }
}
