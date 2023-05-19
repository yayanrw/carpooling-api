<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'SUPERADMIN',
            'email' => 'superadmin@example.com',
            'password' => Hash::make("Bismillah."),
            'role' => 'SUPERADMIN',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'ADMIN',
            'email' => 'admin@example.com',
            'password' => Hash::make("Bismillah."),
            'role' => 'ADMIN',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'APPROVER',
            'email' => 'approver@example.com',
            'password' => Hash::make("Bismillah."),
            'role' => 'APPROVER',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'DRIVER',
            'email' => 'driver@example.com',
            'password' => Hash::make("Bismillah."),
            'role' => 'DRIVER',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'ENDUSER',
            'email' => 'enduser@example.com',
            'password' => Hash::make("Bismillah."),
            'role' => 'ENDUSER',
        ]);
    }
}
