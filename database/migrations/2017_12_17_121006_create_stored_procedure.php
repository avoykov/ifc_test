<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoredProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::unprepared("
          CREATE OR REPLACE FUNCTION requests2events() RETURNS trigger AS \$api_requests_migrate$
            BEGIN
              INSERT INTO events (data, token, count)
                VALUES (NEW.data :: JSON -> 'data', NEW.data :: JSON -> 'token', (NEW.data :: JSON ->> 'count')::INTEGER);

              RETURN NULL;
            END;
          \$api_requests_migrate$ LANGUAGE plpgsql;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
