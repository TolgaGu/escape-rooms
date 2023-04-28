<?php

namespace App\Http\Controllers;

use App\Models\EscapeRooms;
use Illuminate\Http\Request;

class EscapeRoomsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/escape-rooms",
     *     operationId="getEscapeRooms",
     *     tags={"EscapeRooms"},
     *     summary="Get available escape rooms",
     *     description="Show all available escape rooms",
     *     @OA\Response(
     *         response=202,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(EscapeRooms::where('is_available', 1)->get());
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
        //
    }

     /**
     * @OA\Get(
     *     path="/escape-rooms/{id}",
     *     operationId="getEscapeRoomsDetails",
     *     tags={"EscapeRooms"},
     *     summary="Get specified escape room",
     *     description="Show specified escape room details",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(EscapeRooms::where('id', $id)->first());
    }

    /**
     * @OA\Get(
     *     path="/escape-rooms/{id}/time-slots",
     *     operationId="getEscapeRoomsTimeSlots",
     *     tags={"EscapeRoomsTimeSlots"},
     *     summary="Get specified escape rooms time slots",
     *     description="Show all time slots of specified escape room",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function timeSlots($id)
    {
        return response()->json(EscapeRooms::with('timsSlots')->where('id', $id)->first());
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
        //
    }
}
