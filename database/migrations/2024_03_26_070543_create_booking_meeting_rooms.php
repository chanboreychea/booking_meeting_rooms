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
        Schema::create('booking_meeting_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');
            $table->string('date', 50);
            $table->string('topicOfMeeting');
            $table->string('directedBy');
            $table->string('meetingLevel');
            $table->string('member');
            $table->string('room');
            $table->string('time');
            $table->text('description')->nullable();
            $table->string('isApprove', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_meeting_rooms');
    }
};
