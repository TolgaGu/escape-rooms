<?php

namespace Database\Seeders;

use App\Models\Bookings;
use App\Models\TimeSlots;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $listUsers = User::where('email', 'not like', 'test@test.com')->get();
        $listTimeSlots = TimeSlots::all();

        foreach ($listTimeSlots as $timeSlots) {

            foreach ($listUsers as $users) {

                Bookings::create([
                    'price' => $timeSlots->price,
                    'information' => '',
                    'status' => true,
                    'users_id' => $users->id,
                    'time_slots_id' => $timeSlots->id
                ]);
            }
            $timeSlots->free_seats_number -= count($listUsers);
            $timeSlots->save();
        }
    }
}
