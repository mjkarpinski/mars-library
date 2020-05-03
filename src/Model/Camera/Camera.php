<?php

declare(strict_types=1);

abstract class Camera implements InterfaceCamera {

    private $name;

    public function getName() {
        return $this->name;
    }
}