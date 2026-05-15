<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Phones', 'Laptops', 'Tablets', 'Earphones', 'Chargers',
            'Shirts', 'Pants', 'Jackets', 'Hats', 'Bags',
            'ID Cards', 'Passports', 'Licenses', 'Cards',
            'Rings', 'Necklaces', 'Watches', 'Bracelets',
            'Books', 'Notebooks', 'Pens', 'Calculators',
            'House Keys', 'Car Keys', 'Padlocks',
            'Wallets', 'Purses', 'Coin Purses',
            'Balls', 'Rackets', 'Helmets', 'Gloves',
            'Others',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}