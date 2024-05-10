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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('document')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('trade');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('status')->default(true);
            $table->json('keys')->nullable();
            $table->string('origin')->nullable();
            $table->text('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
