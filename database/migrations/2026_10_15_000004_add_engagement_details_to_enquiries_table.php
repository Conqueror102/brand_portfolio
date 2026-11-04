<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->string('phone', 40)->nullable()->after('email');
            $table->string('proposed_date', 60)->nullable()->after('organisation');
            $table->string('location', 150)->nullable()->after('proposed_date');
            $table->string('audience', 200)->nullable()->after('location');
            $table->unsignedInteger('participants')->nullable()->after('audience');
            $table->text('internal_notes')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropColumn(['phone', 'proposed_date', 'location', 'audience', 'participants', 'internal_notes']);
        });
    }
};
