<?php

declare(strict_types=1);

namespace MarsRovers\Request;

use MarsRovers\Model\Picture\Picture as PictureModel;
use MarsRovers\Exception\InvalidRoverException;
use MarsRovers\Model\Picture\PictureFactory;
use MarsRovers\Model\Rover\Rover;
use MarsRovers\Service\Data\InputDataInterface;
use Exception;

class Picture {
    private $rover;
    private $camera;
    private $sol;
    private $data;

    public function __construct(string $rover, string $camera, int $sol, InputDataInterface $data)
    {
        $this->rover = $rover;
        $this->camera = $camera;
        $this->sol = $sol;
        $this->data = $data;
    }

    public function getPicture(): PictureModel
    {
        if (!$this->setRover()) {
            return PictureFactory::pictureNotAvailable('Wrong rover, or camera name');
        }


    }


    private function setRover(): bool {
        if (!$this->validateRover()) {
            return false;
        }

        $this->rover = $this->data->getRovers()[$this->rover];

        if (!$this->validateCamera()) {
            return false;
        }

        return true;
    }

    private function validateRover(): bool
    {
        return isset($this->data->getRovers()[$this->rover]);
    }

    private function validateCamera(): bool
    {
        return $this->rover->cameraAvailable($this->camera);
    }

}
