<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 100);
            $table->text('description');
            $table->text('requirements');
            $table->string('location', 100);
            $table->string('sector', 50);
            $table->enum('type', ['kerja_dari_kantor', 'kerja_dari_rumah']);
            $table->enum('paid', ['tersedia', 'tidak_tersedia']);
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
        Schema::dropIfExists('vacancies');
    }
}
