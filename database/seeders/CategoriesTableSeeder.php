<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Pay Slip',
            'Unique Certification',
        ];
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
