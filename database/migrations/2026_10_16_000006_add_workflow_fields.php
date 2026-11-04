<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->foreignId('assigned_to')->nullable()->after('status')->constrained('users')->nullOnDelete();
            $table->date('follow_up_on')->nullable()->after('assigned_to');
            $table->date('scheduled_for')->nullable()->after('follow_up_on');
        });
        DB::table('enquiries')->where('status', 'awaiting_info')->update(['status' => 'follow_up']);

        Schema::table('mentorship_applications', function (Blueprint $table) {
            $table->foreignId('assigned_to')->nullable()->after('status')->constrained('users')->nullOnDelete();
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('assigned_to');
            $table->dropColumn(['follow_up_on', 'scheduled_for']);
        });
        Schema::table('mentorship_applications', fn (Blueprint $table) => $table->dropConstrainedForeignId('assigned_to'));
        Schema::table('testimonials', fn (Blueprint $table) => $table->dropColumn('is_featured'));
    }
};
