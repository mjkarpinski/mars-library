<?php

declare(strict_types=1);

namespace MarsRovers\Service;

use MarsRovers\Request\Picture as PictureRequest;

class NasaApi {
    const NASA_URL = 'https://api.nasa.gov/mars-photos/api/v1/rovers/';

    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    private function buildUrl(PictureRequest $pictureRequest): string
    {
        return self::NASA_URL
            . $pictureRequest->getRover()->getName()
            . '/photos?' .http_build_query([
                'sol' => $pictureRequest->getSol(),
                'api_key' => $this->apiKey,
                'camera' => $pictureRequest->getRover()->getActiveCamera()->getCode()
            ]);
    }

    public function call(PictureRequest $pictureRequest): array
    {
        var_dump($this->buildUrl($pictureRequest));
        return json_decode(file_get_contents($this->buildUrl($pictureRequest)), true);
    }
}