<?php

use Illuminate\Database\Seeder;
use App\Models\User\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                "name" => "mir cheng",
                "email" => "cheng@erpboost.com",
                "password" => bcrypt("aaa111!!!"),
            ],
        ])->each(function ($data) {
            User::create($data);
        });
    }
}
