<?php

namespace App\Exceptions;

use Exception;
use FastRoute\RouteParser\Std;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Anik\Form\ValidationException as FormValidationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        FormValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof HttpResponseException) {
            return $exception->getResponse();
        } elseif ($exception instanceof ModelNotFoundException) {
            $exception = new NotFoundHttpException($exception->getMessage(), $exception);
        } elseif ($exception instanceof AuthorizationException) {
            $exception = new HttpException(403, $exception->getMessage());
        } elseif ($exception instanceof ValidationException) {
            return response()->json($exception->errors(), $exception->status);
        } elseif ($exception instanceof FormValidationException) {
            return response()->json($exception->getResponse(), $exception->getStatusCode());
        } elseif ($exception instanceof Http\HttpException) {
            return response()->json(new \stdClass(), $exception->getStatus());
        }

        $fe = FlattenException::create($exception);

        return response()->json($fe->toArray(), $fe->getStatusCode(), $fe->getHeaders());
    }
}
