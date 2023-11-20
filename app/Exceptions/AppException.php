<?php
namespace App\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Enums\AppErrorTypeEnum;
use Throwable;
use Exception;

class AppException extends Exception
{
    /**
     * @var string
     */
    protected $errorType;
    /**
     * @var integer
     */
    protected $statusCode = 0;
    /**
     * @var mixed
     */
    protected $details;

    /**
     * AppException constructor.
     *
     * @param string $message
     * @param int $code
     * @param string $errorType
     * @param Throwable|null $previous
     */
    public function __construct($message, $errorType, $statusCode = null, $details = null, Throwable $previous = null)
    {
        if ($errorType) {
            $this->errorType = $errorType;
        }

        if ($statusCode) {
            $this->statusCode = $statusCode;
        }

        if ($details) {
            $this->details = $details;
        }

        if(is_array($message)) {
            $message = json_encode($message, true);
        }

        parent::__construct($message, 0, $previous);
    }

    /**
     * @param int $line
     * @return $this
     */
    public function setLine(int $line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * @param string $filePath
     * @return $this
     */
    public function setFile(string $filePath)
    {
        $this->file = $filePath;

        return $this;
    }

    /**
     * @todo: на удаление (не исаользовать)
     * @deprecated
     *
     * @param string $message
     * @param string $errorType
     * @throws AppException
     */
    public static function throw(string $message, string $errorType)
    {
        throw new self($message, $errorType);
    }

    /**
     * @return string
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
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
    public function render($request, AppException $exception)
    {
        $error_type = $exception->getErrorType();
        $statusCode = $this->getStatusCode();
        if ($statusCode > 0) {
            $status = $statusCode;
        } else {
            $status = AppErrorTypeEnum::statusByType($error_type);
        }

        $message = $exception->getMessage();
        $payload = [
            'status' => $status,
            'error' => strtoupper($error_type),
            'message' => $message
        ];
        if($this->details) {
            $payload['details'] = $this->details;
            $payload['detail'] = reset($this->details)[0];
        }

        $payload['file'] = $this->getFile() . ':' . $this->getLine();
        if (env('APP_DEBUG')) {
            $payload['trace'] = explode("\n", $this->getTraceAsString());
        }

        if ($exception->statusCode === Response::HTTP_INTERNAL_SERVER_ERROR) {
            //Log::error($message, $payload);
        }

        return response()->json($payload, $status);
    }
}
