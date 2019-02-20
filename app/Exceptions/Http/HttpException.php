<?php

namespace App\Exceptions\Http;

abstract class HttpException extends \Exception {
    public abstract function getStatus(): int;
}
