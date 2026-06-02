<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_showings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->foreignId('sales_person_id')->constrained('sales_persons')->onDelete('cascade');
            $table->date('show_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_showings');
    }
};
