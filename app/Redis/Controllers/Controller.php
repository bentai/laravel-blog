<?php


namespace App\Redis\Controllers;

use Illuminate\Contracts\Redis\Factory;

class Controller
{
    protected $redis;
    public function __construct(Factory $redis)
    {
        $this->redis = $redis;
    }

}
