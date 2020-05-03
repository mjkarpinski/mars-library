<?php

declare(strict_types=1);

namespace MarsRovers\Model\Rover;

use DateTimeImmutable;

class Rover {
    private $name;
    private $availableCameras;
    private $landingDate;

    public function __construct(string $name, array $availableCameras, DateTimeImmutable $landingDate)
    {
        $this->name = $name;
        $this->availableCameras = $availableCameras;
        $this->landingDate = $landingDate;
    }

    public function cameraAvailable(string $camera): bool {
        return isset($this->availableCameras[$camera]);
    }
}