<?php

declare(strict_types=1);

namespace MarsRovers\Model\Camera;

class Camera
{
    private $name = '';
    private $code = '';

    public function __construct(string $name, string $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    public function __toString(): string
    {
        return $this->code .' - '. $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
