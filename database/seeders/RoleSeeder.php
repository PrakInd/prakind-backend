<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::factory()->create([
            'name' => 'admin'
        ]);
        Roles::factory()->create([
            'name' => 'pelamar'
        ]);
    }
}
