<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        User::factory(100)->create()->each(function ($user) {
            $user->assignRole('user');
        });

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ])->assignRole('admin');

        User::factory()->create([
            'name' => 'General User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
        ])->assignRole('user');
    }
}
