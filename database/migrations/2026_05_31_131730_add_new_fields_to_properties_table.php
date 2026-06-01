<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('owner_name')->nullable()->after('title');
            $table->decimal('length', 10, 2)->nullable()->after('area_unit');
            $table->decimal('width', 10, 2)->nullable()->after('length');
            $table->string('facing')->nullable()->after('corner_plot');
            $table->text('remarks')->nullable()->after('facing');
            $table->string('via')->nullable()->after('remarks');
            $table->decimal('sq_yard_rate', 12, 2)->nullable()->after('price');
            $table->string('registry_owner')->nullable()->after('sq_yard_rate');
            $table->string('setup_type')->nullable()->after('registry_owner');
            $table->date('add_on_date')->nullable()->after('setup_type');
            $table->string('build_type')->nullable()->after('add_on_date');
            $table->string('property_condition')->nullable()->after('build_type');
            $table->string('construction_type')->nullable()->after('property_condition');
            $table->string('property_age')->nullable()->after('construction_type');
        });

        DB::statement("ALTER TABLE `properties` CHANGE `property_type` `property_type` VARCHAR(255) NULL DEFAULT NULL");
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'owner_name', 'length', 'width', 'facing', 'remarks', 'via',
                'sq_yard_rate', 'registry_owner', 'setup_type', 'add_on_date',
                'build_type', 'property_condition', 'construction_type', 'property_age',
            ]);
        });

        DB::statement("ALTER TABLE `properties` CHANGE `property_type` `property_type` ENUM('Plot', 'Flat', 'Villa') NULL DEFAULT NULL");
    }
};
