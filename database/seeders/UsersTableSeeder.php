<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Let's clear the users table first
        User::truncate();

        $faker = \Faker\Factory::create();

        // Let's make sure everyone has the same password and 
        // let's hash it before the loop
        $password = Hash::make('mysecurepassword');

        User::create([
            'name' => 'Tester Account',
            'email' => 'test@test.com',
            'date_of_birth' => date('Y/m/d', strtotime('-26 years')),
            'password' => $password,
        ]);

        // And now let's generate users for our app:
        for ($i = 0; $i < 3; $i++) {
            User::create([
                'name' => $faker->name,
                'date_of_birth' => $faker->dateTimeBetween()->format('Y/m/d'),
                'email' => $faker->email,
                'password' => $password,
            ]);
        }
    }
}
