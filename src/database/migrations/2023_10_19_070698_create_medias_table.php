<?php

use IBoot\Core\App\Models\Menu;
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
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('disk')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('image_lg')->nullable();
            $table->string('image_md')->nullable();
            $table->string('image_sm')->nullable();
            $table->integer('parent_id')->nullable()->index();
            $table->boolean('is_directory')->default(false);
            $table->unsignedBigInteger('size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medias');
    }
};
