<?php

declare(strict_types=1);

namespace MarsRovers\Response;

interface ResponseInterface {
    public function render($data);
}