<?php

declare(strict_types=1);

namespace MarsRovers\Model\Rover;

use DateTimeImmutable;
use MarsRovers\Model\Camera\Camera;

class Rover
{
    private $name;
    private $availableCameras;
    private $landingDate;
    private $activeCamera;

    public function __construct(string $name, array $availableCameras, DateTimeImmutable $landingDate)
    {
        $this->name = $name;
        $this->availableCameras = $availableCameras;
        $this->landingDate = $landingDate;
    }

    public function cameraAvailable(string $camera): bool
    {
        return isset($this->availableCameras[$camera]);
    }

    public function setActiveCamera(string $camera): void
    {
        $this->activeCamera = $this->availableCameras[$camera];
    }

    public function getActiveCamera(): Camera
    {
        return $this->activeCamera;
    }

    public function getName(): string
    {
        return $this->name;
    }
}