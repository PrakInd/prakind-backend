<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('institution_id')->constrained('institutions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('address');
            $table->string('phone', 20);
            $table->string('semester');
            $table->string('gpa', 10);
            $table->string('cv')->nullable()->default('cv.pdf');
            $table->string('transcript')->nullable()->default('transcript.pdf');
            $table->string('portfolio')->nullable()->default('portfolio.pdf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
