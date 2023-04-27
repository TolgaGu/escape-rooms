<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TimeSlots;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EscapeRoomsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TimeSlotsSeeder::class);
        $this->call(BookingsTableSeeder::class);
    }
}
