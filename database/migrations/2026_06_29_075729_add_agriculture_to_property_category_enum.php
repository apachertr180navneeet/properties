<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `properties` CHANGE `property_category` `property_category` ENUM('Residential', 'Commercial', 'Agriculture') NULL DEFAULT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `properties` CHANGE `property_category` `property_category` ENUM('Residential', 'Commercial') NULL DEFAULT NULL");
    }
};
