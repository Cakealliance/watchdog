<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('healthcheck_registry', function (Blueprint $table) {
            $table->json('loading_time')->after('failed_checks_timestamps')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('healthcheck_registry', function (Blueprint $table) {
            $table->dropColumn('loading_time');
        });
    }
};
