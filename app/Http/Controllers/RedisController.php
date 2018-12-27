<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;
use Redis;

class RedisController extends Controller
{
    public function testRedis()
    {
        Redis::connection();
        Redis::set('name','Dawn');
        $value = Redis::get('name');

        $info = User::find(1);
        Redis::set('user_key',$info);
        if(Redis::exists('user_key')){
            $values = Redis::get('user_key');
        }else{
            $values = User::find(1);
        }
        dump($values);
    }

    public function showRedis()
    {
        $redis = Redis::get('name');
        var_dump(gettype($redis));
    }
}
