<?php

declare(strict_types=1);

namespace MarsRovers\Service\Data;

use MarsRovers\Validator\InputDataValidator;
use MarsRovers\Model\Rover\RoverFactory;
use MarsRovers\Model\Camera\CameraFactory;
use Symfony\Component\Yaml\Yaml;
use Exception;
use DateTimeImmutable;

class FileInputData implements InputDataInterface
{
    private $rovers;
    private $cameras;
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function getRovers(): array
    {
        $data = $this->getData();

        $this->setupCameras($data);
        $this->setupRovers($data);

        return $this->rovers;
    }

    private function getData(): array
    {
        try {
            $data = Yaml::parseFile($this->filePath);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }

        if (!InputDataValidator::validate($data)) {
            return ['error' => 'Input data invalid'];
        }

        return $data;
    }

    private function setupRovers($data): void
    {

        foreach ($data['rovers'] as $name => $rover) {
            $availableCameras = [];

            foreach ($rover['cameras'] as $camera) {
                $availableCameras[$camera] = $this->cameras[$camera];
            }

            $this->rovers[$name] = RoverFactory::create(
                $name,
                $availableCameras,
                DateTimeImmutable::createFromFormat(
                    'd/m/Y',
                    $rover['landingDate'])
            );
        }
    }

    private function setupCameras(array $data): void
    {
        foreach ($data['cameras'] as $code => $camera) {
            $this->cameras[$code] = CameraFactory::create($camera['name'], $code);
        }
    }
}