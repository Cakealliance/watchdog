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
        Schema::create('healthcheck_registry', function (Blueprint $table) {
            $table->id();

            $table->string('site_name');
            $table->date('date');
            $table->integer('brand_id');
            $table->integer('total_checks');
            $table->integer('failed_checks');
            $table->json('failed_checks_timestamps')->nullable();
            $table->timestamps();

            $table->unique(['brand_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('healthcheck_registry');
    }
};
