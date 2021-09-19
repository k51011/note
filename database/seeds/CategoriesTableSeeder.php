<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        Category::create(
            ['name'=>'緊急：高','color'=>'red'],
        );
         Category::create(
            ['name'=>'緊急：中','color'=>'yellow'],
        );
         Category::create(
            ['name'=>'緊急：低','color'=>'blue'],
        );
         Category::create(
            ['name'=>'進行中','color'=>'green'],
        );
         Category::create(
            ['name'=>'完了','color'=>'black'],
        );

    }
}
