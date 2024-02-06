<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        \App\Models\User::truncate();       
        \App\Models\City::truncate();       
        \App\Models\County::truncate();       
        Schema::enableForeignKeyConstraints();

        \App\Models\User::factory(100)->create();
        \App\Models\City::factory(20)->create();
        \App\Models\County::factory(50)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
