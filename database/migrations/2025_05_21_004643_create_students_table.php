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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string("fName");
            $table->string("lName");
            $table->string("nName");
            $table->integer("age");
            $table->foreignId("level_id")->constrained("levels")->onDelete("cascade");
            $table->foreignId("course_id")->constrained("courses")->onDelete("cascade");
            $table->foreignId("block_id")->constrained("blocks")->onDelete("cascade");
            $table->string("phone");
            $table->string("email");
            $table->string("gender");
            $table->dateTime("birthdate");
            $table->string("image")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
