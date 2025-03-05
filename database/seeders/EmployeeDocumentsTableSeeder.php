<?php

namespace Database\Seeders;

use App\Models\EmployeeDocument;
use Illuminate\Database\Seeder;

class EmployeeDocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeDocument::factory()->count(10)->create();
    }
}
