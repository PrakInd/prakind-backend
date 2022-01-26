<?php

namespace Database\Seeders;

use App\Models\ApplicantFile;
use Illuminate\Database\Seeder;

class ApplicantFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApplicantFile::factory()->count(3)->create();
    }
}
