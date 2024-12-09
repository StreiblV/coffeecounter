<?php

namespace Database\Seeders;

use App\Models\Entry;
use Illuminate\Database\Seeder;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Entry::factory(10)->create([
            "user_id" => 1
        ]);
        Entry::factory(10)->create([
            "user_id" => 2,         
        ]);
    }
}
