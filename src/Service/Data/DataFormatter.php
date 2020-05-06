<?php

declare(strict_types=1);

namespace MarsRovers\Service\Data;

use MarsRovers\Model\Picture\Picture;

class DataFormatter
{
    public static function nasaToPictures($data)
    {
        return array_map(function($photo) {
            return new Picture(
                $photo['img_src'],
                $photo['earth_date'],
                $photo['rover']['name'],
                $photo['camera']['name'],
                $photo['sol']
            );
        }, $data['photos']);
    }
}