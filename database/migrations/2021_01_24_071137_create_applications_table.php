<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('profiles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('group_id')->nullable()->constrained('groups')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('vacancy_id')->constrained('vacancies')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', ['dalam_seleksi', 'diterima', 'ditolak', 'diambil', 'tidak_diambil']);
            $table->string('certificate')->nullable()->default('certificate.pdf');
            $table->string('period_start');
            $table->string('period_end');
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
        Schema::dropIfExists('applications');
    }
}
