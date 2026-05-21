<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `properties` CHANGE `property_type` `property_type` ENUM('Plot', 'Flat', 'Villa') NULL DEFAULT NULL");
        DB::statement("ALTER TABLE `properties` CHANGE `property_category` `property_category` ENUM('Residential', 'Commercial') NULL DEFAULT NULL");
        DB::statement("ALTER TABLE `properties` CHANGE `area_unit` `area_unit` ENUM('Sq.ft', 'Sq.yard', 'Bigha', 'Acre') NULL DEFAULT 'Sq.ft'");
        DB::statement("UPDATE `properties` SET `corner_plot` = 'No' WHERE `corner_plot` = '0' OR `corner_plot` IS NULL OR `corner_plot` = 0");
        DB::statement("UPDATE `properties` SET `corner_plot` = 'Yes' WHERE `corner_plot` = '1' OR `corner_plot` = 1");
        DB::statement("ALTER TABLE `properties` CHANGE `corner_plot` `corner_plot` ENUM('Yes', 'No') NOT NULL DEFAULT 'No'");
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('property_type')->nullable()->change();
            $table->string('property_category')->nullable()->change();
            $table->string('area_unit')->default('Sq.ft')->change();
            $table->boolean('corner_plot')->default(false)->change();
        });
    }
};