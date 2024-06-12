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
        // Create trigger for update stok after insert on product_in
        DB::statement("
            CREATE TRIGGER updateStockInsertProductIn
            AFTER INSERT ON products_in
            FOR EACH ROW
            BEGIN
                UPDATE product
                SET stock = stock + NEW.qty_masuk
                WHERE id = NEW.product_id;
            END
        ");

        DB::statement("
            CREATE TRIGGER updateStockDeleteProductIn
            AFTER DELETE ON products_in
            FOR EACH ROW
            BEGIN
                UPDATE product
                SET stock = stock - OLD.qty_masuk
                WHERE id = OLD.product_id;
            END;

        ");

        DB::statement("
            CREATE TRIGGER updateStockUpdateProductIn
            AFTER UPDATE ON products_in
            FOR EACH ROW
            BEGIN
                UPDATE product
                SET stock = stock + NEW.qty_masuk - OLD.qty_masuk
                WHERE id = NEW.product_id;
            END;
        ");

        // Create trigger for update stok after insert on products_out
        DB::statement("
            CREATE TRIGGER updateStockInsertProductOut
            AFTER INSERT ON products_out
            FOR EACH ROW
            BEGIN
                UPDATE product
                SET stock = stock - NEW.qty_keluar
                WHERE id = NEW.product_id;
            END;
        ");

        DB::statement("
            CREATE TRIGGER updateStockDeleteProductOut
            AFTER DELETE ON products_out
            FOR EACH ROW
            BEGIN
                UPDATE product
                SET stock = stock + OLD.qty_keluar
                WHERE id = OLD.product_id;
            END;
        ");

        DB::statement("
            CREATE TRIGGER updateStockUpdateProductOut
            AFTER UPDATE ON products_out
            FOR EACH ROW
            BEGIN
                UPDATE product
                SET stock = stock - NEW.qty_keluar + OLD.qty_keluar
                WHERE id = NEW.product_id;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS updateStockInsertProductIn");
        DB::unprepared("DROP TRIGGER IF EXISTS updateStockDeleteProductIn");
        DB::unprepared("DROP TRIGGER IF EXISTS updateStockUpdateProductIn");
        DB::unprepared("DROP TRIGGER IF EXISTS updateStockInsertProductOut");
        DB::unprepared("DROP TRIGGER IF EXISTS updateStockDeleteProductOut");
        DB::unprepared("DROP TRIGGER IF EXISTS updateStockUpdateProductOut");

    }
};
