<?php

namespace App\Exceptions;

use App\Http\ResponseCodes;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
//        \Illuminate\Auth\AuthenticationException::class,
//        \Illuminate\Auth\Access\AuthorizationException::class,
//        \Symfony\Component\HttpKernel\Exception\HttpException::class,
//        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
//        \Illuminate\Session\TokenMismatchException::class,
//        \Illuminate\Validation\ValidationException::class,
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, \Exception $exception)
    {
        if ($request->wantsJson()) {
            return $this->renderExceptionAsJson($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Render an exception into a JSON response
     *
     * @param $request
     * @param Exception $exception
     * @return SymfonyResponse
     */
    protected function renderExceptionAsJson($request, Exception $exception)
    {
        // Default response
        $response = [
            'code'    => $exception->getCode(),
            'message' => $exception->getMessage(),
            'data'    => [],
        ];

        // laravel converts AuthorizationException to 403 HttpException
        // and ModelNotFoundException to 404 NotFoundHttpException
        $exception = $this->prepareException($exception);

        // Add debug info if app is in debug mode
        if (config('app.debug')) {
            $response['debug']['exception'] = get_class($exception);
            $response['debug']['trace'] = $exception->getTrace();
        }

        // Deal with some specific framework exceptions
        switch ($exception) {
            case $exception instanceof QueryException:
                $response['code']    = ResponseCodes::SQL_EXCEPTION;
                $response['message'] = '数据库操作失败';
                $response['data']    = [];
                break;
            case $exception instanceof ValidationException:
                $jsonResponse = $this->convertValidationExceptionToResponse($exception, $request);
                $response['code']    = $jsonResponse->getStatusCode();
                $response['message'] = Arr::first($jsonResponse->original)[0];
                $response['data']    = $jsonResponse->original;
                break;
            case $this->isHttpException($exception):
                $response['code']    = $exception->getStatusCode();
                $response['message'] = $exception->getMessage();
                break;
            default:
                break;
        }

        return response()->json($response, 200);
    }

}
