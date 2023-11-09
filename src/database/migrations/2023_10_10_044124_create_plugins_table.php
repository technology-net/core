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
        Schema::create('plugins', function (Blueprint $table) {
            $table->id();
            $table->string('name_package')->unique();
            $table->string('composer_name')->nullable();
            $table->json('menu_items')->nullable();
            $table->string('version')->nullable();
            $table->boolean('status')->default(0)->comment('1: Installed, 0: Uninstalled');
            $table->boolean('is_default')->default(false);
            $table->string('scripts')->nullable();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plugins');
    }
};
