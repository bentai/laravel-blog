<?php

namespace App\Redis\Controllers;

/**
 * Class HashController
 * @package App\Redis\Controllers
 * Redis 有序集合和集合一样也是string类型元素的集合,且不允许重复的成员。
 *  不同的是每个元素都会关联一个double类型的分数。redis正是通过分数来为集合中的成员进行从小到大的排序。
 *  有序集合的成员是唯一的,但分数(score)却可以重复。
 */
class ZSetController extends Controller
{
    public function index()
    {
        // ZADD key score1 member1 [score2 member2]
        // 向有序集合添加一个或多个成员，或者更新已存在成员的分数
//        $this->redis->zadd('scores', 98, 'English', 90, 'physics');
//        $this->redis->zrem('scores', 99, 'physics');
//        $this->redis->zadd('scores', 88, 'pysics');
//        $this->redis->zadd('scores', 66, 'test');
        // ZCOUNT key min max
        // 获取有序集合的成员数
//        dump($this->redis->zcard('scores'));
        // ZCOUNT key min max
        // 计算在有序集合中指定区间分数的成员数
//        dump($this->redis->zcount('scores', 90, 100));
        // 有序集合中对指定成员的分数加上增量 increment
        // ZINCRBY key increment member
        // 获取指定区间内的成员
//        $this->redis->zincrby('scores', 1, 'English');
        // 返回有序集 key 中，指定区间内的成员。
//        dump($this->redis->zrange('scores', 0, -1, true));
        // 返回有序集 key 中，所有 score 值介于 min 和 max 之间(包括等于 min 或 max )的成员。有序集成员按 score 值递增(从小到大)次序排列。
//        dump($this->redis->zrangebyscore('scores', 100, 101));
        // 返回有序集 key 中成员 member 的排名 其中有序集成员按分数值递增(从小到大)顺序排列。
//        dump($this->redis->zrank('scores', 'physics'));
        // 移除有序集 key 中的一个或多个成员，不存在的成员将被忽略 区间以下标参数
//        $this->redis->zremrangebyrank('scores', 0, 1);
        // 移除有序集 key 中，所有 score 值介于 min 和 max 之间(包括等于 min 或 max )的成员。 区间以score参数
//        $this->redis->zremrangebyscore('scores', 0, 1);

//        dump($this->redis->zrevrange('scores', 0, -1, true)); // 从大到小
//        dump($this->redis->zrange('scores', 0, -1, true));// 从小到大
        //
//        dump($this->redis->);



    }


}
