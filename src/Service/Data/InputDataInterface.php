<?php

declare(strict_types=1);

namespace MarsRovers\Service\Data;
use MarsRovers\Model\Rover\Rover;

interface InputDataInterface
{
    /**
     * @return Rover[]
     */
    function getRovers(): array;
}