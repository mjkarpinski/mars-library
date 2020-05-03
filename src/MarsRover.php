<?php

declare(strict_types=1);

namespace MarsRovers;

use MarsRovers\Request\Picture as PictureRequest;
use MarsRovers\Request\Picture;
use MarsRovers\Response\Json as JsonResponse;
use MarsRovers\Response\ResponseInterface;
use MarsRovers\Service\Data\DataFormatter;
use MarsRovers\Service\Data\FileInputData;
use MarsRovers\Service\Data\InputDataInterface;
use MarsRovers\Service\NasaApi;
use Exception;

class MarsRover
{
    private $nasaApi;
    private $inputData;

    public function __construct(
        string $apiKey,
        InputDataInterface $inputData = null
    ) {
       $this->inputData = $inputData ?: new FileInputData(__DIR__ . '/initData.yml');
       $this->nasaApi = new NasaApi($apiKey);
    }

    public function getAvailableRovers(): array
    {
        return $this->inputData->getRovers();
    }

    public function getPictures(string $rover, string $camera, int $sol, ResponseInterface $responseType = null)
    {
        if ($responseType === null) {
            $responseType = new JsonResponse();
        }

        try {
            $responseType->render(
                DataFormatter::nasaToPictures(
                    $this->nasaApi->call(
                        new PictureRequest($rover, $camera, $sol, $this->inputData)
                    )
                )
            );
        } catch (Exception $e) {
            $responseType->render(['Error' => $e->getMessage()]);
        }
    }
}