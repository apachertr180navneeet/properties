<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if ($this->hasIndex('customers', 'customers_email_unique')) {
                $table->dropUnique(['email']);
            }
        });

        Schema::table('sales_persons', function (Blueprint $table) {
            if ($this->hasIndex('sales_persons', 'sales_persons_email_unique')) {
                $table->dropUnique(['email']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('email')->unique()->change();
        });

        Schema::table('sales_persons', function (Blueprint $table) {
            $table->string('email')->unique()->change();
        });
    }

    private function hasIndex(string $table, string $index): bool
    {
        $schema = DB::connection()->getDatabaseName();
        $result = DB::select("
            SELECT COUNT(1) AS cnt FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND INDEX_NAME = ?
        ", [$schema, $table, $index]);
        return !empty($result) && $result[0]->cnt > 0;
    }
};
