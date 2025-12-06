<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $smartphonesId = Category::where('slug', 'smartphones')->first()->id;
        $laptopsId = Category::where('slug', 'laptops')->first()->id;
        $tvsId = Category::where('slug', 'tvs')->first()->id;
        $headphonesId = Category::where('slug', 'headphones')->first()->id;

        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'Флагманський смартфон від Apple з потрійною камерою',
                'price' => 45999,
                'category_id' => $smartphonesId,
                'images' => json_encode(['iphone15pro.jpg']),
                'is_active' => true
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'slug' => 'samsung-galaxy-s24',
                'description' => 'Потужний смартфон з Android та чудовою камерою',
                'price' => 34999,
                'category_id' => $smartphonesId,
                'images' => json_encode(['samsungs24.jpg']),
                'is_active' => true
            ],
            [
                'name' => 'MacBook Air M2',
                'slug' => 'macbook-air-m2',
                'description' => 'Легкий та потужний ноутбук для роботи та навчання',
                'price' => 59999,
                'category_id' => $laptopsId,
                'images' => json_encode(['macbookair.jpg']),
                'is_active' => true
            ],
            [
                'name' => 'Samsung 55" QLED',
                'slug' => 'samsung-55-qled',
                'description' => 'Телевізор з якісним зображенням та Smart TV',
                'price' => 32999,
                'category_id' => $tvsId,
                'images' => json_encode(['samsungtv.jpg']),
                'is_active' => true
            ],
            [
                'name' => 'AirPods Pro',
                'slug' => 'airpods-pro',
                'description' => 'Бездротові навушники з шумозаглушенням',
                'price' => 8999,
                'category_id' => $headphonesId,
                'images' => json_encode(['airpods.jpg']),
                'is_active' => true
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}