<?php

namespace App\Observers;

class TagObserver
{
    //
    public function saving()
    {
        dd(111);
    }

    public function creating()
    {
        dd(222);
    }

    public function created()
    {
        dd(33);
    }
}
