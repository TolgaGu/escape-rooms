<?php

namespace Database\Seeders;

use App\Models\EscapeRooms;
use App\Models\TimeSlots;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSlotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // //
        TimeSlots::truncate();

        $faker = \Faker\Factory::create();


        $startDate = new DateTime();
        $endDate = clone $startDate;
        $endDate->modify('+1 week');

        $listEscapeRooms = EscapeRooms::all();
        $listStartTimes = [
            $faker->dateTimeBetween($startDate, $endDate)->format('Y/m/d H:i'),
            $faker->dateTimeBetween($startDate, $endDate)->format('Y/m/d H:i'),
            $faker->dateTimeBetween($startDate, $endDate)->format('Y/m/d H:i')
        ];

        $listFreeSeatsNumber = [4,5,5];
        foreach($listEscapeRooms as $escapeRooms){
            for ($i = 0; $i < 3; $i++) {
                TimeSlots::create([
                    'start_time' => $listStartTimes[$i],
                    'price' => $faker->randomFloat(2, 20, 30),
                    'free_seats_number' => $listFreeSeatsNumber[$i],
                    'is_available' => true,
                    'escape_rooms_id' => $escapeRooms->id
                ]);
            }
        }
        
    }
}
