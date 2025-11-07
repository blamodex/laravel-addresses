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
        Schema::create('administrative_areas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('country_id')->index();
            $table->string('name');
            $table->string('code');

            // Standard timestamps + soft deletes
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['country_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subnations');
    }
};