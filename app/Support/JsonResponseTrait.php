<?php

namespace App\Support;

trait JsonResponseTrait {
    public function jsonSuccessfulResponse() {
        return response()->json(new \stdClass());
    }
}
