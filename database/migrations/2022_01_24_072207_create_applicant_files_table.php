<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onUpdate('cascade')->onDelete('cascade');
            $table->string('recommendation_letter')->default('recommendation_letter.pdf');
            $table->string('proposal')->nullable()->default('proposal.pdf');
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
        Schema::dropIfExists('applicant_files');
    }
}
