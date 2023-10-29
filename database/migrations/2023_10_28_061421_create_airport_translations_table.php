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
        Schema::create('airport_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('airport_id');
            $table->string('language_code', 10);
            $table->string('name', 60);
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->foreign('airport_id')->references('id')->on('airports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airport_translations');
    }
};
