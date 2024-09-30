<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create(['email' => 'manager@admin.com']);
        User::factory()->create(['email' => 'admin@admin.com', 'is_admin' => true]);

        User::factory(10)->create();
    }
}
