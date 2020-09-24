<?php

namespace App\Services\ImageMakers;

class ImageMakerMain extends BaseImageMaker
{

    function name()
    {
        $text = $this->data['name'];
        $font_size = (int)($this->width * 0.066);
        $white = imagecolorallocate($this->image, 255, 255, 255);

        $box = imagettfbbox($font_size, 0, __DIR__ . '/18214.ttf', $text);
        $text_width = $box[2] - $box[0];
        $text_height = $box[7] - $box[1];

        $x = ($this->width / 2) - ($text_width / 2);
        $y = ($this->height / 2) - ($text_height / 1.1);

        imagefttext($this->image, $font_size, 0, $x, $y, $white, __DIR__ . '/18214.ttf', $text);
    }

    function id()
    {
        $text = $this->data['id'];
        $font_size = (int)($this->width * 0.066);
        $white = imagecolorallocate($this->image, 255, 255, 255);

        $box = imagettfbbox($font_size, 0, __DIR__ . '/18214.ttf', $text);
        $text_width = $box[2] - $box[0];
        $text_height = $box[7] - $box[1];

        $x = $this->width - $text_width*1.5;
        $y = ($this->height - $this->height) - $text_height*2;

        imagefttext($this->image, $font_size, 0, $x, $y, $white, __DIR__ . '/18214.ttf', $text);
    }

}