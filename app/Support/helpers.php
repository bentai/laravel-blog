<?php

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Str;

if (!function_exists('generate_english_slug')) {
    /**
     * Generate English slug
     *
     * @param $content
     *
     * @throws ErrorException
     *
     * @return string
     */
    function generate_english_slug($content)
    {
        $local = config('app.local');
        if ('en' !== $local){
            $googleTranslate = new GoogleTranslate();
            $content = $googleTranslate->setUrl("http://translate.google.cn/translate_a/single")
                ->setSource($local)
                ->translate($content);
        }
        return Str::slug($content);

    }
}
