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
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('app_users');
        Schema::dropIfExists('phone_otps');
        Schema::dropIfExists('email_otps');
        Schema::dropIfExists('splash_screens');
    }

    public function down(): void
    {
    }
};
