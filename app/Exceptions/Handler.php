<?php

namespace App\Exceptions;

use App\MyApp;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'status' => false,
                'message' => MyApp::DATA_NOT_FOUND,
            ], MyApp::HTTP_NOT_FOUND);
        }
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'status' => false,
                'message' => MyApp::UNAUTHENTICATED,
            ], MyApp::HTTP_UNAUTHORIZED);
        }
        if ($exception instanceof MissingAbilityException) {
            return response()->json([
                'status' => false,
                'message' => MyApp::ACCESS_DENIED,
            ], MyApp::HTTP_FORBIDDEN);
        }
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'status' => false,
                'message' => MyApp::PAGE_NOT_FOUND,
            ], MyApp::HTTP_NOT_FOUND);
        }
        return parent::render($request, $exception);
    }
}
