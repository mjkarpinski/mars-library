<?php

declare(strict_types=1);

namespace MarsRovers\Request;

use MarsRovers\Exception\BadInputException;
use MarsRovers\Model\Rover\Rover;
use MarsRovers\Service\Data\InputDataInterface;
use MarsRovers\Validator\PictureValidator;

class Picture
{
    /** @var $rover Rover */
    private $rover;
    private $roverName;
    private $cameraName;
    private $sol;
    private $data;

    /**
     * @throws BadInputException
     */
    public function __construct(string $roverName, string $cameraName, int $sol, InputDataInterface $data)
    {
        $this->roverName = $roverName;
        $this->cameraName = $cameraName;
        $this->sol = $sol;
        $this->data = $data;

        if (!PictureValidator::validate($roverName, $cameraName, $data)) {
            throw new BadInputException();
        }

        $this->rover = $this->data->getRovers()[$this->roverName];
        $this->rover->setActiveCamera($this->cameraName);
    }

    public function getRover(): Rover
    {
        return $this->rover;
    }

    public function getSol(): int
    {
        return $this->sol;
    }
}
