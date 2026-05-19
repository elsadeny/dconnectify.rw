<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('legacy_id')->nullable()->unique()->after('id');
        });

        Schema::table('listings', function (Blueprint $table) {
            $table->string('legacy_id')->nullable()->unique()->after('id');
            $table->string('availability')->nullable()->index()->after('status');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('legacy_id')->nullable()->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropUnique(['legacy_id']);
            $table->dropColumn('legacy_id');
        });

        Schema::table('listings', function (Blueprint $table) {
            $table->dropUnique(['legacy_id']);
            $table->dropIndex(['availability']);
            $table->dropColumn(['legacy_id', 'availability']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['legacy_id']);
            $table->dropColumn('legacy_id');
        });
    }
};
