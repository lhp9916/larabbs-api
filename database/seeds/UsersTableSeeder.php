<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //获取faker实例
        $faker = app(Faker\Generator::class);
        $avatars = [
            'https://avatars3.githubusercontent.com/u/324764?s=460&v=4',
            'https://avatars1.githubusercontent.com/u/10591282?s=460&v=4',
            'https://avatars1.githubusercontent.com/u/66577?s=460&v=4'
        ];

        $users = factory(User::class)
            ->times(10)
            ->make()
            ->each(function ($user, $index)
            use ($faker, $avatars) {
                $user->avatar = $faker->randomElement($avatars);
            });
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        //插入到数据库中
        User::insert($user_array);


        $user = User::find(1);
        $user->name = 'lhp';
        $user->email = 'lhp9916@qq.com';
        $user->save();
    }
}
