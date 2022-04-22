<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if( method_exists($exception,'responseJson') )
        {
            return $exception->responseJson();
        }

        if($request->ajax() || $request->wantsJson())
        {
            // this part is from render function in Illuminate\Foundation\Exceptions\Handler.php
            // works well for json
            $exception = $this->prepareException($exception);

            if ($exception instanceof \Illuminate\Http\Exception\HttpResponseException) {
                return $exception->getResponse();
            } elseif ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                return $this->unauthenticated($request, $exception);
            } elseif ($exception instanceof \Illuminate\Validation\ValidationException) {
                return $this->convertValidationExceptionToResponse($exception, $request);
            }

            // we prepare custom response for other situation such as modelnotfound
            $response = [];
            $response['error'] = [
                'message' => 'Error Found',
                'status_code' => 500,
                'error' => $exception->getMessage()
            ];

            // we look for assigned status code if there isn't we assign 500
            $statusCode = method_exists($exception, 'getStatusCode')
                ? $exception->getStatusCode()
                : 500;

            if(config('app.debug')) {
                $response['error']['trace'] = $exception->getTrace();
                $response['error']['code'] = $exception->getCode();
                $response['error']['status_code'] = $statusCode;
            }

            return response()->json($response, $statusCode);
        }
        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
