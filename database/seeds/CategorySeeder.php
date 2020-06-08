<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id' => 1,
                'title' => 'Programming',
                'active' => 1,
            ],
            [
                'id' => 2,
                'title' => 'Network',
                'active' => 1,
            ],
        ];
        foreach($categories as $category){
            Category::updateOrCreate(['id' => $category['id']], $category);
        }
    }
}
