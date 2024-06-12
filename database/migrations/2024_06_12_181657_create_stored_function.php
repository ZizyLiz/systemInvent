<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS namaKategori');
        DB::statement("
            CREATE FUNCTION namaKategori(category VARCHAR(5))
            RETURNS VARCHAR(30)
            DETERMINISTIC
            BEGIN
                DECLARE val VARCHAR(30);

                IF category = 'A' THEN
                    SET val = 'ALAT';
                ELSEIF category = 'M' THEN
                    SET val = 'MODAL';
                ELSEIF category = 'BHP' THEN
                    SET val = 'BAHAN HABIS PAKAI';
                ELSEIF category = 'BTHP' THEN
                    SET val = 'BAHAN TIDAK HABIS PAKAI';
                END IF;
                RETURN val;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS namaKategori');
    }
};
