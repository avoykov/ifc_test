<?php

use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
           CREATE TRIGGER api_requests_migrate
           AFTER INSERT ON api_requests
           FOR EACH ROW
           EXECUTE PROCEDURE requests2events();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS api_requests_migrate');
        DB::unprepared('DROP FUNCTION IF EXISTS requests2events');
    }
}
