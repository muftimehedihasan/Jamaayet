<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=> bcrypt('password'),
            'is_admin' => true,
        ]);

        for ($i = 0; $i < 10; $i++) {
            DB::table('dreams')->insert([
                'user_id' => DB::table('users')->first()->id,
                'content' => fake()->realText(150),
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }
    }
}
