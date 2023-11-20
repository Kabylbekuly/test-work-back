<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Helpers\Json;
use App\Helpers\JsonResponseHelper;

/**
 * Class ApiResponse
 * @package App\Http\Middleware
 * @author Amantay Orynbayev
 */
class ApiResponse
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $originalData = [];

        $response = $next($request);
        # в режиме дебага не оборачивать в структуру
        if ($request->get('dd')) {
            return $response;
        }

        if ($response instanceof JsonResponse) {
            $originalData = (array)$response->getData();
        }

        if ($response instanceof Response) {
            $originalData = $response->getOriginalContent();
        }

        if (!isset($originalData['success']) || !isset($originalData['data'])) {
            $originalData = is_array($originalData) ? $originalData : (array)$originalData;
            $payload = JsonResponseHelper::wrap(($originalData ?? []), $this->isSuccess($response));
            if (app()->has('debugbar')
                && app('debugbar')->isEnabled()
            ) {
                $payload['debug'] = app('debugbar')->getData();
            }

            $json = Json::encode($payload);
            $response->setContent($json);
        }

        $response->header('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @return bool
     */
    private function isSuccess($response)
    {
        $statusCode = $response->getStatusCode();

        return ($statusCode >= 200 && $statusCode < 300);
    }
}
