<?php
declare(strict_types=1);

namespace MarsRovers;

use MarsRovers\Request\Picture as PictureRequest;
use MarsRovers\Model\Picture\Picture as PictureModel;
use MarsRovers\Service\Data\FileInputData;
use MarsRovers\Service\Data\InputDataInterface;

class MarsRover {
    private $activeRover;
    private $activeCamera;
    private $currentSol;
    private $availableRovers;
    private $apiKey;
    private $inputData;

    public function __construct(
        string $apiKey,
        InputDataInterface $inputData = null
    ) {
       $this->inputData = $inputData ?: new FileInputData(__DIR__ . '/initData.yml');
       $this->apiKey = $apiKey;
    }

    public function getAvailableRovers(): array
    {
        return $this->inputData->getRovers();
    }

    public function getPicture(string $rover, string $camera, int $sol): PictureModel
    {
        return (new PictureRequest($rover, $camera, $sol, $this->inputData))->getPicture();
    }


}