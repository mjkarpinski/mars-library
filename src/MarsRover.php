<?php

declare(strict_types=1);

namespace MarsRovers;

use MarsRovers\Exception\MarsRoverException;
use MarsRovers\Request\Picture as PictureRequest;
use MarsRovers\Request\Picture;
use MarsRovers\Response\Json as JsonResponse;
use MarsRovers\Response\ResponseInterface;
use MarsRovers\Service\Data\DataFormatter;
use MarsRovers\Service\Data\FileInputData;
use MarsRovers\Service\Data\InputDataInterface;
use MarsRovers\Service\NasaApi;

class MarsRover
{
    private $nasaApi;
    private $inputData;

    public function __construct(string $apiKey, InputDataInterface $inputData = null)
    {
       $this->inputData = $inputData;
       $this->nasaApi = new NasaApi($apiKey);
    }

    public function getAvailableRovers(): array
    {
        return $this->inputData->getRovers();
    }

    public function getPictures(string $rover, string $camera, int $sol, ResponseInterface $responseType = null)
    {
        $responseType = $responseType ?: new JsonResponse();

        try {
            return $responseType->render(
                DataFormatter::nasaToPictures(
                    $this->nasaApi->call(
                        new PictureRequest(
                            $rover,
                            $camera,
                            $sol,
                            $this->inputData ?: new FileInputData(__DIR__ . '/initData.yml')
                        )
                    )
                )
            );
        } catch (MarsRoverException $e) {
            return $responseType->render([
                'Error' => $e->getMessage(),
            ]);
        }
    }
}