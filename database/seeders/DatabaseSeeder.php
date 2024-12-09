<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Michi',
            'password'=> '$2y$10$vv8G3FWY1PMpqXm1tF8NY.qoOmD3mRzk1zPjtsRBMHfcvBJvPHBui',
        ]);
        User::factory()->create([
            'name' => 'Viki',            
            'password'=> '$2y$10$iwaRISTstcIgv9XQBa2mze73xKFtRW1Bk1I/MBHEtgMA7tKbljyW6',
        ]);

        $this->call(EntrySeeder::class);        
    }
}
