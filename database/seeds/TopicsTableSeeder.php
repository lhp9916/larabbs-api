<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        //拿到所有用户的 id数组
        $user_ids = User::all()->pluck('id')->toArray();
        //分类的id
        $category_ids = Category::all()->pluck('id')->toArray();
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)
            ->times(10)
            ->make()
            ->each(function ($topic, $index)
            use ($user_ids, $category_ids, $faker) {
                $topic->user_id = $faker->randomElement($user_ids);
                $topic->category_id = $faker->randomElement($category_ids);
            });

        Topic::insert($topics->toArray());
    }

}

