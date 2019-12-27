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
        // 元素添加到集合中 元素已存在不进行操作
//        $this->redis->sadd('myset', 'ceshi');
        // 返回集合所有元素
//        dump($this->redis->smembers('myset'));
        // 判断指定元素是否在集合中
//        dump($this->redis->sismember('myset', 'ceshi'));
        // 返回集合中元素的数量
//        $this->redis->sadd('myset', 'test');
//        dump($this->redis->scard('myset'));

//        dump($this->redis->smembers('myset'));

        // 移除并返回集合中的一个随机元素
//        dump($this->redis->spop('myset'));
//        dump($this->redis->smembers('myset'));
        // 随机返回集合中的一个元素
//        dump($this->redis->srandmember('myset'));
        // 删除集合中指定元素,忽略不存在的元素
//        $this->redis->sadd('myset', 'hello');
//        dump($this->redis->srem('myset', 'hello'));

//        $this->redis->sadd('myset', 'apple');
//        $this->redis->sadd('myset', 'age');
        // 迭代返回匹配的元素  默认从0下标开始
//        dump($this->redis->sscan('myset', 'match', 'a*', 5));
//        $this->redis->sadd('myset2', 'hello');
//        dump($this->redis->smove('myset', 'myset2', 'test'));
        // 返回所有给定集合的差集
//        dump($this->redis->sdiff('myset', 'myset2'));
        // 查询所有给定集合的差集,并保存到目的集合中, 若目的集合已存在则覆盖它
        // store 商店, 存储
//        $this->redis->sdiffstore('myset3', 'myset', 'myset2');
//        dump($this->redis->smembers('myset3'));
        // 返回所有给定集合的交集
//        dump($this->redis->sinter('myset', 'myset2'));
        // 返回所有给定集合的交集并存储在目的集合中
//        $this->redis->sinterstore('myset3', 'myset', 'myset2');
//        dump($this->redis->smembers('myset3'));
        // 返回给定集合的并集
//        dump($this->redis->sunion('myset', 'myset2', 'myset3'));
        // 返回所有给定的集合的并集并存储在目的集合中
//        $this->redis->sunionstore('myset4', 'myset', 'myset2'. 'myset3');
//        dump($this->redis->smembers('myset4'));
    }


}
