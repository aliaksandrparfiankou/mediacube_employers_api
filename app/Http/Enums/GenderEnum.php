<?php

namespace App\Http\Enums;

class GenderEnum extends Enum {
    const MALE = 1;
    const FEMALE = 2;
    const TRANSGENDER = 3;

    public static function toArray(): array
    {
        return [
            self::MALE,
            self::FEMALE,
            self::TRANSGENDER,
        ];
    }

    public static function toString(): string
    {
        return join(",", self::toArray());
    }
}
