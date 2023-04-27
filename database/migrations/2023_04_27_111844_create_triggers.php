<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //set is_available false on time_slots when free_seats_number is 0
        DB::unprepared('
            CREATE TRIGGER decrement_seats
                AFTER UPDATE OF free_seats_number ON time_slots
                WHEN NEW.free_seats_number <= 0 AND (
                    SELECT COUNT(*) FROM time_slots
                    WHERE id = NEW.id AND free_seats_number <= 0
                ) = 1
                BEGIN
                    UPDATE time_slots SET is_available = 0 WHERE id = NEW.id;
            END;
        ');

        //set is_available false on escape_rooms when all releated time_slots
        //have their is_available column at false
        DB::unprepared('
            CREATE TRIGGER check_time_slots_availability
                AFTER UPDATE OF is_available ON time_slots
                BEGIN
                    UPDATE escape_rooms SET is_available = 0
                        WHERE id IN (
                            SELECT DISTINCT escape_rooms_id FROM time_slots
                            WHERE is_available = 0 AND escape_rooms_id = NEW.escape_rooms_id
                        ) AND NOT EXISTS (
                            SELECT 1 FROM time_slots
                                WHERE escape_rooms_id = NEW.escape_rooms_id
                                AND is_available = 1
                        );
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_update_free_places`');
        DB::unprepared('DROP TRIGGER `check_time_slots_availability`');
    }
};
