<?php

namespace App\Exceptions\Http;

use Illuminate\Http\Response;

class ResourceNotFoundHttpException extends HttpException {
    public function getStatus(): int
    {
        return Response::HTTP_NOT_ACCEPTABLE;
    }
}
