<?php

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Faker\Provider\Image;

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

if (!function_exists('cdn_url')) {
    /**
     * Generate a url for the CDN.
     *
     * @param $path
     *
     * @return string
     */
    function cdn_url($path)
    {
        return URL::assetFrom(config('bjyblog.cdn_domain'), $path);
    }
}

if (!function_exists('format_url')) {
    /**
     * Format URL
     *
     * @param $url
     *
     * @return string
     */
    function format_url($url)
    {
        if (preg_match('/^http(s)?:\/\//', $url) === 0) {
            $url = 'http://' . $url;
        }

        return strtolower(rtrim($url, '/'));
    }
}

if (!function_exists('add_text_water')) {
    /**
     * 给图片添加文字水印
     *
     * @param $file
     * @param $text
     * @param string $color
     *
     * @return mixed
     */
    function add_text_water($file, $text, $color = '#0B94C1')
    {
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if ($extension !== 'gif') {
            $image = Image::make($file);
            $image->text($text, $image->width() - 20, $image->height() - 30, function ($font) use ($color) {
                $font->file(public_path('fonts/msyh.ttf'));
                $font->size(15);
                $font->color($color);
                $font->align('right');
                $font->valign('bottom');
            });
            $image->save($file);
        }
    }
}
