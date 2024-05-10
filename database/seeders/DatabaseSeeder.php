<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory(10)->create();

        Ticket::factory(100)->recycle($user)->create();

        User::factory()->create([
            'name' => 'The Manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('password'),
            'is_manager' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
