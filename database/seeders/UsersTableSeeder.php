<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@aulab.it',
            'password' => Hash::make('12345678'),
        ]);
        $admin->assignRole('admin');

        $employee = User::factory()->create([
            'name' => 'Employee',
            'email' => 'employee@aulab.it',
            'password' => Hash::make('12345678'),
        ]);
        $employee->assignRole('employee');

        User::factory()->count(10)->create()->each(fn ($user) => $user->assignRole('employee'));
    }
}
