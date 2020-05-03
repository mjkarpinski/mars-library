<?php

declare(strict_types=1);

namespace MarsRovers\Request;

use MarsRovers\Model\Rover\Rover;
use MarsRovers\Service\Data\InputDataInterface;
use Exception;

class Picture
{
    /** @var $rover Rover */
    private $rover;
    private $roverName;
    private $cameraName;
    private $sol;
    private $data;

    public function __construct(string $roverName, string $cameraName, int $sol, InputDataInterface $data)
    {
        $this->roverName = $roverName;
        $this->cameraName = $cameraName;
        $this->sol = $sol;
        $this->data = $data;

        if (!$this->buildRequest()) {
            throw new Exception('Wrong rover or camera');
        }
    }

    public function buildRequest(): bool
    {
        return $this->setRover() && $this->setCamera();
    }

    private function setRover(): bool
    {
        if (!$this->validateRover()) {
            return false;
        }

        $this->rover = $this->data->getRovers()[$this->roverName];

        return true;
    }

    public function getRover(): Rover
    {
        return $this->rover;
    }

    public function getSol(): int
    {
        return $this->sol;
    }

    private function setCamera(): bool
    {
        if (!$this->validateCamera()) {
            return false;
        }

        $this->rover->setActiveCamera($this->cameraName);

        return true;
    }

    private function validateRover(): bool
    {
        return isset($this->data->getRovers()[$this->roverName]);
    }

    private function validateCamera(): bool
    {

        return $this->rover->cameraAvailable($this->cameraName);
    }
}
