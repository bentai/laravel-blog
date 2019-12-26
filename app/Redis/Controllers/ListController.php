<?php

namespace App\Redis\Controllers;

/**
 * Class HashController
 * @package App\Redis\Controllers
 * Redis列表是简单的字符串列表，按照插入顺序排序。你可以添加一个元素到列表的头部（左边）或者尾部（右边）
    一个列表最多可以包含 232 - 1 个元素 (4294967295, 每个列表超过40亿个元素)
 */
class ListController extends Controller
{
    public function index()
    {
        // 从头部插入一个值
//        $this->redis->lpush('city', 'huainan');
        // 移除并返回列表的第一个元素，若 key 不存在或不是列表则返回 false。
        // 从尾部插入一个值
//        $this->redis->rpush('city', 'hefei');
        // 获取列表所有值
//        dump($this->redis->lrange('city', 0, -1));


        // 当前列表不存在时不进行操作
//        dump($this->redis->rpushx('city', 'ShangHai'));
//        $this->redis->rpushx('city', 'GuangZhou');
        // 移除第一个元素并返回
//        dump($this->redis->lpop('city'));
        // 移除最后一个元素并返回
//        dump($this->redis->rpop('city'));
//        dump($this->redis->brpop('city', 1));
//        dump($this->redis->blpop('city', 10));
        //
//        dump($this->redis->lindex('city', 0));
//        dump($this->redis->lindex('city', -1));
        // 指定索引更改value
//        $this->redis->lset('city', 3, 'hefei');

        // 在指定元素之前插入值
//        $this->redis->linsert('city', 'BEFORE', 'hefei', 'panji');
        // 在指定元素之后插入值
//        $this->redis->linsert('city', 'AFTER', 'hefei', 'nanjin');
        // 获取list 所有元素
//        dump($this->redis->lrange('city', 0, -1));
        // LREM KEY_NAME COUNT VALUE
        // 根据count值删除指定数量的value， count为正从表头开始，为负从表尾开始，为0删除所有
//        $this->redis->lrem('city',  1, 'ShangHai');
        // 保留指定区间内的元素，删除区间外元素
        $this->redis->ltrim('city', 0, 2);
                dump($this->redis->lrange('city', 0, -1));




    }

    public function tests()
    {
        $this->redis->lpush('city', 'hefei111');
    }


}
