<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('property_type')->nullable()->after('title');
            $table->string('property_category')->nullable()->after('property_type');
            $table->enum('property_status', ['active', 'inactive'])->default('active')->after('property_category');
            $table->string('city')->nullable()->after('location');
            $table->string('state')->nullable()->after('city');
            $table->text('address')->nullable()->after('state');
            $table->string('pin_code')->nullable()->after('address');
            $table->string('plot_number')->nullable()->after('pin_code');
            $table->decimal('area_size', 12, 2)->nullable()->after('plot_number');
            $table->string('area_unit')->default('Sq.ft')->after('area_size');
            $table->boolean('corner_plot')->default(false)->after('area_unit');
            $table->decimal('stamp_duty', 12, 2)->nullable()->after('price');
            $table->string('property_photo')->nullable()->after('stamp_duty');
            $table->string('registry_document')->nullable()->after('property_photo');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'property_type',
                'property_category',
                'property_status',
                'city',
                'state',
                'address',
                'pin_code',
                'plot_number',
                'area_size',
                'area_unit',
                'corner_plot',
                'stamp_duty',
                'property_photo',
                'registry_document',
            ]);
        });
    }
};
