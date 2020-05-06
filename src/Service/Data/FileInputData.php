<?php

declare(strict_types=1);

namespace MarsRovers\Service\Data;

use MarsRovers\Exception\ParseException;
use MarsRovers\Validator\InputDataValidator;
use MarsRovers\Model\Rover\RoverFactory;
use MarsRovers\Model\Camera\CameraFactory;
use Symfony\Component\Yaml\Exception\ExceptionInterface;
use Symfony\Component\Yaml\Yaml;
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

    /**
     * @throws ParseException
     */
    private function getData(): array
    {
        try {
            $data = Yaml::parseFile($this->filePath);
        } catch (ExceptionInterface $e) {
            throw new ParseException('Parsing file failed');
        }

        if (!InputDataValidator::validate($data)) {
            throw new ParseException('Data missing key fields');
        }

        return $data;
    }

    private function setupRovers(array $data): void
    {
        foreach ($data['rovers'] as $name => $rover) {
            $availableCameras = [];

            foreach ($rover['cameras'] as $camera) {
                $availableCameras[strtoupper($camera)] = $this->cameras[$camera];
            }

            $this->rovers[strtoupper($name)] = RoverFactory::create(
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

    public function getRovers(): array
    {
        $data = $this->getData($this->filePath);
        $this->setupRovers($data);
        $this->setupCameras($data);

        return $this->rovers;
    }
}