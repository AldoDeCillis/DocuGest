<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\EmployeeDocument;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeDocumentFactory extends Factory
{
    protected $model = EmployeeDocument::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'file_path' => 'documents/'.$this->faker->uuid.'.pdf',
            'expiration_date' => $this->faker->optional()->date(),
        ];
    }
}
