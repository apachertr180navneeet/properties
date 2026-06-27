<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales_persons', function (Blueprint $table) {
            $table->string('phone_2')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('sales_persons', function (Blueprint $table) {
            $table->dropColumn('phone_2');
        });
    }
};
