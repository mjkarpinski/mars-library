<?php

declare(strict_types=1);

namespace MarsRovers\Model\Rover;

use DateTimeImmutable;

class RoverFactory {
    public static function create(string $name, array $availableCameras, DateTimeImmutable $landingDate)
    {
        return new Rover($name, $availableCameras, $landingDate);
    }
}