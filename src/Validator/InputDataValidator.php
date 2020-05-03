<?php

declare(strict_types=1);

namespace MarsRovers\Validator;

class InputDataValidator {
    public static function validate($data) {
        return is_array($data) && isset($data['rovers']) && isset($data['cameras']);
    }
}
