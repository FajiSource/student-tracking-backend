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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("level_id")->constrained("levels")->onDelete("cascade");
            $table->foreignId("course_id")->constrained("courses")->onDelete("cascade");
            $table->json("first_schedule")->default(
                json_encode([
                    "day" => null,
                    "start_time" => null,
                    "end_time" => null,
                ])
            );
            $table->json("second_schedule")->default(
                json_encode([
                    "day" => null,
                    "start_time" => null,
                    "end_time" => null,
                ])
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
