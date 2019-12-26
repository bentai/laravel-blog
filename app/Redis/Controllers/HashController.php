<?php

namespace App\Redis\Controllers;

/**
 * Class HashController
 * @package App\Redis\Controllers
 * Redis hash 是一个 string 类型的 field 和 value 的映射表，hash 特别适合用于存储对象。
 */
class HashController extends Controller
{
    public function index()
    {
//        $this->redis->hset('user', 'name', 'tiantian');
        /*$this->redis->hset('user', 'sex', 'man');

        dump($this->redis->hget('user', 'sex'));
        // 检测sex字段是否在user Hash 中设置
        dump($this->redis->hexists('user', 'sex'));
        // 删除 一个 字段
        dump($this->redis->hdel('user', 'sex'));*/

        // 同时设置多个hash 字段

//        $this->redis->hmset('admin_user', ['name' => '管理员', 'sex' => 'man', 'age' => 26]);

        // 获取hash表中多个字段
//        dump($this->redis->hmget('admin_user', ['name', 'age']));

        // 获取hash表中所有字段
//        dump($this->redis->hgetall('admin_user'));
        // 获取hash 表中所有键名
//        dump($this->redis->hkeys('admin_user'));
        // 获取hash表中所有键值
//        dump($this->redis->hvals('admin_user'));
        // 判断hash 表中是否又该字段 没有该字段进行赋值，有该字段不进行操作
//        $this->redis->hsetnx('admin_user', 'money', '100');
//        dump($this->redis->hgetall('admin_user' ));
        // 获取hash 表 字段数量
//        dump($this->redis->hlen('admin_user'));
        // 对hash表中字段指定增量 增量值为负数进行减法 字段不存在先创建初始值为0 再进行操作 ，字段为string 返回false
//        dump($this->redis->hincrby('admin_user', 'name', 10));
        // 对hash表中字段进行浮点值增量
        dump($this->redis->hincrbyfloat('admin_user', 'age', 0.5));
    }


}
