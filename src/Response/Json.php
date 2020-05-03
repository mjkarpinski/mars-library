<?php
declare(strict_types=1);

namespace MarsRovers\Response;

class Json implements ResponseInterface {
    public function render($data){
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}