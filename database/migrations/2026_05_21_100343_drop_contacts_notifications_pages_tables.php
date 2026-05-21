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
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('notification_users');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('pages');
    }

    public function down(): void
    {
    }
};
