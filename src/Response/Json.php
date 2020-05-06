<?php
declare(strict_types=1);

namespace MarsRovers\Response;

class Json implements ResponseInterface
{
    public function render($data)
    {
        return json_encode($data);
    }
}