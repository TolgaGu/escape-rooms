<?php

namespace Database\Seeders;

use App\Models\EscapeRooms;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EscapeRoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        EscapeRooms::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 3; $i++) {
            EscapeRooms::create([
                'theme' => $faker->words(3, true),
                'max_size' => $faker->randomDigitNotNull(),
                'is_available' => true
            ]);
        }

    }
}
