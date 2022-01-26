<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            InstitutionSeeder::class,
            DepartmentSeeder::class,
            ProfileSeeder::class,
            GroupSeeder::class,
            CompanySeeder::class,
            VacancySeeder::class,
            // CertificateSeeder::class,
            ApplicationSeeder::class,
            ApplicantFileSeeder::class,
        ]);
    }
}
