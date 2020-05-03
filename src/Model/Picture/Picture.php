<?php

declare(strict_types=1);

namespace MarsRovers\Model\Picture;

class Picture
{
    public $url;
    public $date;
    public $rover;
    public $camera;
    public $sol;

    public function __construct(string $url, string $date, string $rover, string $camera, int $sol)
    {
        $this->url = $url;
        $this->date = $date;
        $this->rover = $rover;
        $this->camera = $camera;
        $this->sol = $sol;
    }
}