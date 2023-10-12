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
            $table->string('name_package');
            $table->string('composer_name')->nullable();
            $table->string('version')->nullable();
            $table->string('status')->default('Installed')->comment('Installed, Uninstalled');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_parent')->default(true);
            $table->bigInteger('child_of')->nullable();
            $table->string('scripts')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->unique();
            $table->string('route')->nullable();
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
