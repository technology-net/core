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
        if (!Schema::hasColumn('permissions', 'group_name')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->string('group_name')->after('name')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('permissions', 'group_name')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->dropColumn('group_name');
            });
        }
    }
};