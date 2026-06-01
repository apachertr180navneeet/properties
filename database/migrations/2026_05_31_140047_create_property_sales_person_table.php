<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_sales_person', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->foreignId('sales_person_id')->constrained('sales_persons')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['property_id', 'sales_person_id']);
        });

        DB::statement("INSERT INTO property_sales_person (property_id, sales_person_id, created_at, updated_at)
                       SELECT id, sales_person_id, NOW(), NOW() FROM properties WHERE sales_person_id IS NOT NULL");

        Schema::table('properties', function (Blueprint $table) {
            $table->foreignId('sales_person_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->foreignId('sales_person_id')->nullable(false)->change();
        });

        Schema::dropIfExists('property_sales_person');
    }
};
