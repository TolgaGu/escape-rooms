<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\TimeSlots;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        return response()->json(Bookings::where('users_id', $userId)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = (array) $request->all();
        $validate = $this->validate_data($data);

        if (!$validate[0])
            return response()->json(
                $this->responseFormat(false, $validate[1], 400)
            );


        $timeSlotId = $data['time_slots_id'];
        $userId = auth()->user()->id;



        //Crtical code fighting against double bookings
        try {
            DB::transaction(function () use ($timeSlotId, $userId) {
                // Vérification de la disponibilité du time slot
                $timeSlot = TimeSlots::where('id', $timeSlotId)
                    ->where('free_seats_number', '>', 0)
                    ->where('is_available', true)
                    ->lockForUpdate()->first();

                if (!$timeSlot) {
                    throw new \Exception('Time slots not available');
                }

                // Double bookings verification
                $existingBooking = Bookings::where('time_slots_id', $timeSlotId)
                    ->where('users_id', $userId)
                    ->where('status', true)
                    ->first();
                if ($existingBooking) {
                    throw new \Exception('User already has a booking for this time slot');
                }


                $timeSlotPrice = $timeSlot->price;
                $information = '';

                // Birthday verification if so then apply 10% discount
                $user = User::findOrFail($userId);
                if (Carbon::parse($user->date_of_birth)->isBirthday()) {
                    $timeSlotPrice = $timeSlotPrice * 0.9;
                    $information = 'A 10% birthday discount has been applied';
                }


                // Insertion of the new booking
                Bookings::create([
                    'price' => $timeSlotPrice,
                    'information' => $information,
                    'time_slots_id' => $timeSlotId,
                    'users_id' => $userId,
                ]);

                // Update free seats number
                $timeSlot->free_seats_number -= 1;
                $timeSlot->save();
            });
        } catch (\Exception $e) {

            #log errors

            //response in case of error
            return response()->json(
                $this->responseFormat(false, $e->getMessage()), 400
            );
        }

        return response()->json(
            $this->responseFormat(true, 'Booking added succesfully',201)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->check()) {
            $userId = auth()->user()->id;

            // Existing bookings verification
            $booking = Bookings::where('id', $id)
                ->where('users_id', $userId)
                ->where('status', true)
                ->first();

            if (!$booking) {
                return response()->json($this->responseFormat(false,'User has no booking with specified time slot id'));
            }


            //add one free seat number on time slot if it is always available
            $timeSlot = TimeSlots::where('id', $booking->time_slots_id)
                    ->where('free_seats_number', '>', 0)
                    ->where('is_available', true)
                    ->lockForUpdate()->first();

            // Update free seats number
            $timeSlot->free_seats_number += 1;
            $timeSlot->save();

            $booking->status = false;
            $booking->save();

            return response()->json($this->responseFormat(true,'Booking canceled succesfully'));
        } else {
            // utilisateur non authentifié
            return response()->json('Invalide request : user is not authenticated', 400);
        }
    }

    private function validate_data($data)
    {
        if (!isset($data['time_slots_id']))
            return array(false, 'Missing parameter : time_slots_id');
        if (!is_int($data['time_slots_id']))
            return array(false, 'Invalid format : time_slots_id must be an integer');
        if (!auth()->check())
            return array(false, 'Invalide request : user is not authenticated');

        return array(true);
    }

    private function responseFormat(Bool $bool, String $message)
    {
        return ['success' => $bool, 'message' => $message];
    }
}
