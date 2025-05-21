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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId("subject_id")->constrained("subjects")->onDelete("cascade");
            $table->string("name");
            $table->boolean("done")->default(false);
            $table->dateTime("startTime");
            $table->dateTime("endTime");
            $table->integer("maxScore");
            $table->integer("passingScore");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
