<?php

declare(strict_types=1);

namespace MarsRovers\Model\Picture;

class PictureFactory
{
    public $url;
    public $date;
    public $rover;
    public $camera;
    public $sol;

    public static function picture(string $url, string $date, string $rover, string $camera, int $sol): Picture
    {
        return new Picture($url, $date, $rover, $camera, $sol);
    }

    public static function pictureNotAvailable(string $message): Picture
    {
        return new Picture($message,'N/A', 'N/A', 'N/A', 0);
    }

}