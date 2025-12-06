<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Смартфони', 'slug' => 'smartphones', 'description' => 'Сучасні смартфони та телефони'],
            ['name' => 'Ноутбуки', 'slug' => 'laptops', 'description' => 'Ноутбуки для роботи та ігор'],
            ['name' => 'Телевізори', 'slug' => 'tvs', 'description' => 'Телевізори різних діагоналей'],
            ['name' => 'Навушники', 'slug' => 'headphones', 'description' => 'Бездротові та проводні навушники'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}