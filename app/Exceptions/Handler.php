<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if($request->expectsJson()){
                return $this->errorResponse('No data found for your request', 404);
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if($request->expectsJson()){
                return $this->errorResponse('The specific method for the request is invalid', 405);
            }
        });

        $this->renderable(function (HttpException $e, $request) {
            if($request->expectsJson()){
                return $this->errorResponse($e->getMessage(), $e->getStatusCode());
            }
        });
    }
}
