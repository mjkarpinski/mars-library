<?php

declare(strict_types=1);

namespace MarsRovers\Validator;

use MarsRovers\Service\Data\InputDataInterface;

class PictureValidator
{
    public static function validate(string $roverName, string $cameraName, InputDataInterface $data): bool
    {
        return isset($data->getRovers()[$roverName])
            && $data->getRovers()[$roverName]->cameraAvailable($cameraName);
    }
}
