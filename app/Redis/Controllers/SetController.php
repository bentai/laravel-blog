<?php

namespace App\Redis\Controllers;

/**
 * Class HashController
 * @package App\Redis\Controllers
 * Redis 的 Set 是 String 类型的无序集合。集合成员是唯一的，这就意味着集合中不能出现重复的数据。
    Redis 中集合是通过哈希表实现的，所以添加，删除，查找的复杂度都是 O(1)。
 */
class SetController extends Controller
{
    public function index()
    {
        // 元素添加到集合中
//        $this->redis->sadd('set:myset', 'ceshi');
        // 返回集合所有元素
//        dump($this->redis->smembers('myset'));
        // 判断指定元素是否在集合中
//        dump($this->redis->sismember('myset', 'ceshi'));
        // 返回集合中元素的数量
//        $this->redis->sadd('set:myset', 'test');
        dump($this->redis->scard('set:myset'));

        // 移除并返回集合中的一个随机元素
        dump($this->redis->smembers('set:myset'));
        dump($this->redis->spop('set:myset', 1));
        dump($this->redis->smembers('set:myset'));



    }


}
