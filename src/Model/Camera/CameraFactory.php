<?php

declare(strict_types=1);

namespace MarsRovers\Model\Camera;

class CameraFactory {
    public static function create(string $name, string $code)
    {
        return new Camera($name, $code);
    }
}