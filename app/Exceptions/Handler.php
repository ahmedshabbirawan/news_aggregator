<?php

namespace App\Exceptions;

use App\Http\Responses\AppResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use ReflectionException;

class Handler extends ExceptionHandler
{
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
    }

    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
        if ($exception instanceof ReflectionException) {
            $error = $exception->getMessage();
            return AppResponse::error($error);
        }
        return parent::render($request, $exception);
    }
}
