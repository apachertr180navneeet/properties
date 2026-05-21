<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('area_masters', function (Blueprint $table) {
            $table->id();
            $table->string('area_name');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('sales_person_id')->constrained('sales_persons')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('area_masters');
    }
};
