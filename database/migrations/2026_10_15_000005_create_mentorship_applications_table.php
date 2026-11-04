<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentorship_applications', function (Blueprint $table) {
            $table->id();
            $table->string('cohort', 60);
            $table->string('name', 150);
            $table->string('email', 254)->index();
            $table->string('phone', 40)->nullable();
            $table->string('role', 200);
            $table->string('location', 150);
            $table->text('goals');
            $table->text('outcomes');
            $table->text('motivation');
            $table->text('support')->nullable();
            $table->string('availability', 30);
            $table->string('in_person', 30);
            $table->text('commitment');
            $table->boolean('marketing_consent')->default(false);
            $table->timestamp('privacy_consented_at');
            $table->string('status', 30)->default('submitted')->index();
            $table->string('payment_status', 30)->default('not_requested');
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentorship_applications');
    }
};
