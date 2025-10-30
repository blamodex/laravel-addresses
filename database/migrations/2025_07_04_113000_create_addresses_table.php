<?php

use Blamodex\Address\Database\Migrations;
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('subnation');
            $table->string('postal_code');
            $table->string('country');

            // Polymorphic relationship
            $table->morphs('addressable');

            // Standard timestamps + soft deletes
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};