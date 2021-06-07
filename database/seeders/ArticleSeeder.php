<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::factory()->count(30)->create();
    }
}
