<?php

namespace App\Exceptions;
use App\Enums\AppErrorTypeEnum;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Базовый обработчик ошибок
 *
 * @author Amantay Orynbayev
 */
class CustomHandler extends ExceptionHandler
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
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
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
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($request->get('dd')) {
            return parent::render($request, $exception);
        }

        if($exception instanceof AppException) {
            return $exception->render($request, $exception);
        }

        if($exception instanceof ValidationException) {
            $detailed = $exception->errors();
        }
        $message = $exception->getMessage();
        $statusCode = $this->getStatusCode($exception);
        if ($exception instanceof ModelNotFoundException) {
            $statusCode = AppErrorTypeEnum::statusByType(AppErrorTypeEnum::NOT_FOUND);
        }
        $errorType = strtoupper(str_replace(' ', '_', (Response::$statusTexts[$statusCode] ?? 'UNKNOWN')));
        $appException = new AppException($message, $errorType, $statusCode,$detailed ?? null);
        $appException
            ->setFile($exception->getFile())
            ->setLine($exception->getLine());

        return $appException->render($request, $appException);
    }

    /**
     * Получение кода исключения
     *
     * @param Throwable $exception
     * @return int|null
     */
    protected function getStatusCode(Throwable $exception)
    {
        $statusCode = null;
        if ($exception instanceof ValidationException) {
            $statusCode = $exception->status;
        } elseif ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        }  elseif ($exception instanceof AuthenticationException) {
            $statusCode = Response::HTTP_UNAUTHORIZED;
            Log::info($exception);
            Log::info($statusCode);
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        // Be extra defensive
        if ($statusCode < 100 || $statusCode > 599) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $statusCode;
    }
}
