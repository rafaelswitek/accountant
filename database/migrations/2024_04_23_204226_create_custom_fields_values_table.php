<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('custom_fields_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->nullable()->references('id')->on('custom_fields')->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->onDelete('cascade');
            $table->foreignId('person_id')->nullable()->references('id')->on('people')->onDelete('cascade');
            $table->json('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_fields_values');
    }
};
