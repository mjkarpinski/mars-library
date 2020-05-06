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

    private $sol;
    private $data;

    /**
     * @throws BadInputException
     */
    public function __construct(string $roverName, string $cameraName, int $sol, InputDataInterface $data)
    {
        $roverName = strtolower($roverName);
        $cameraName = strtoupper($cameraName);

        $this->sol = $sol;
        $this->data = $data;

        if (!PictureValidator::validate($roverName, $cameraName, $data)) {
            throw new BadInputException('Bad rover name or camera not available');
        }

        $this->rover = $this->data->getRovers()[$roverName];
        $this->rover->setActiveCamera($cameraName);
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
