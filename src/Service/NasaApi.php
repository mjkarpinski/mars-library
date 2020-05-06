<?php

declare(strict_types=1);

namespace MarsRovers\Service;

use MarsRovers\Exception\BadApiKeyException;
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
        $url = $this->buildUrl($pictureRequest);
        $headers = get_headers($url, 1);

        if ($headers[0] == 'HTTP/1.1 403 Forbidden') {
            throw new BadApiKeyException('Wrong Api key');
        }

        return json_decode(file_get_contents($url), true);
    }
}