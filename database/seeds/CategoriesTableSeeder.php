<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'High Tech',
            'slug' => 'high-tech'
        ]);

        Category::create([
            'name' => 'Hookah',
            'slug' => 'hookah'
        ]);

        Category::create([
            'name' => 'Accesories',
            'slug' => 'accesories'
        ]);

        Category::create([
            'name' => 'Charcoal',
            'slug' => 'charcoal'
        ]);

        Category::create([
            'name' => 'Kits',
            'slug' => 'kits'
        ]);
    }
}
