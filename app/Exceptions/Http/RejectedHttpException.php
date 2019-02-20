<?php

namespace App\Exceptions\Http;

use Illuminate\Http\Response;

class RejectedHttpException extends HttpException {
    public function getStatus(): int
    {
        return Response::HTTP_CONFLICT;
    }
}
