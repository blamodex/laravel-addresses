<?php

declare(strict_types=1);

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
            $table->uuid('uuid')->unique();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('administrative_area_id')->nullable()->constrained('administrative_areas');
            $table->string('postal_code')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');

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