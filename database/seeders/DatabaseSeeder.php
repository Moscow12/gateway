<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@gmail.com',
            'phone' => '+1234567890',
            'password' => 'admin1234',
            'photos' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.freepik.com%2Fimgs%2Ffree-photo%2F2017-12%2F10%2F11%2FDog-running-in-the-snow-free-photo.jpg&psig=AOvVaw0-9-7-1-4-6-2-3-5&ust=1638148612852000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCLD-8-0k8cCFQAAAAAdAAAAABAD',
        ]);

        
    }
}
