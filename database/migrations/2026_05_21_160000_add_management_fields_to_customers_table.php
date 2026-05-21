<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('city')->nullable()->after('phone');
            $table->text('base_requirement')->nullable()->after('city');
            $table->date('visit_date')->nullable()->after('base_requirement');
            $table->unsignedInteger('whatsapp_count')->default(0)->after('visit_date');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('whatsapp_count');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'city',
                'base_requirement',
                'visit_date',
                'whatsapp_count',
                'status',
            ]);
        });
    }
};
