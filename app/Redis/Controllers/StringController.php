<?php

namespace App\Redis\Controllers;

class StringController extends Controller
{
    public function index()
    {
        $this->redis->set('test', 123);
//        dump($this->redis->get('test'));
//        // 从指定指针修改值
//        $this->redis->setRange('test', 3, 456);
//        dump($this->redis->get('test'));
//        // 将给定 key 的值设为 value ，并返回 key 的旧值(old value)。
//        $value = $this->redis->getset('test', 'abc');
//        dump($value);
//        dump($this->redis->get('test'));
//        // 对 key 所储存的字符串值，获取指定偏移量上的位(bit)。
//        $this->redis->setbit('bit', 10086, 2);
//
//        dump($this->redis->getbit('bit', 100));



        // 将值 value 关联到 key ，并将 key 的过期时间设为 seconds (以秒为单位)。  设置过期时间
//        $this->redis->setex('test_name', 10, '10秒过期');

        // 这个命令和 SETEX 命令相似，但它以毫秒为单位设置 key 的生存时间，而不是像 SETEX 命令那样，以秒为单位。
//        $this->redis->psetex('test_name', 10000, '10000毫秒后过期');
//
//        dump($this->redis->get('test_name'));


        // 只有在 key 不存在时设置 key 的值。
//        $this->redis->setnx('test', 'cdn');
//        dump($this->redis->get('test'));
        // 返回 key 所储存的字符串值的长度。
//        dump($this->redis->strlen('test'));

        // 获取所有(一个或多个)给定 key 的值。
//        $this->redis->mset(['test1' => '111', 'test2' => '222']);
//
//        dump($this->redis->mget(['test1', 'test2']));

        // 同时设置一个或多个 key-value 对，当且仅当所有给定 key 都不存在
//        $this->redis->msetnx(['test1' => 111, 'test2' => 222, 'test3' => 333]);
//        dump($this->redis->mget(['test1', 'test2', 'test3'])); // 111,222,null

        // int型数值增1 自增1
//        $this->redis->set('test_name_int', 10);
//        dump($this->redis->get('test_name_int'));
//        $this->redis->incr('test_name_int');
//        // int型数值增加指定值
//        $this->redis->incrby('test_name_int', 100);
        // 增加浮点增量值
//        $this->redis->incrbyfloat('test_name_int', 0.1);
        // int型数值减1 自见1
//        $this->redis->decr('test_name_int', 1);
//        $this->redis->decrby('test_name_int', 5);
//        dump($this->redis->get('test_name_int'));

        $this->redis->append('test', 4456);
        dump($this->redis->get('test'));






    }

    public function tests()
    {
        $this->redis->set('test1', '111');
        dd($this->redis->get('test1'));
        \Cache::put('key', 'value', 10);
        \Cache::put('key', 'value');
        \Cache::put('key', 'value', now()->addMinutes(10));  // 第三个参数可以是 DateTime 对象

      /*  Cache::putMany(['helen' => new Student('helen'), 'jack' => '10'], 10);  // 这个是 ok 的
        Redis::setDriver('string_test_111', 111);
        \Cache::set('string_tests', 1111);
        dd(\Cache::get('string_tests'));*/
    }

}
