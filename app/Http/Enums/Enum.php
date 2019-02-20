<?php

namespace App\Http\Enums;

abstract class Enum {
    public abstract static function toArray(): array;
    public abstract static function toString(): string;
}
