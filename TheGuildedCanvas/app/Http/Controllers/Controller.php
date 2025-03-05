<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{

    /**
     * Handle a successful response.
     *
     * @param  mixed  $result
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResponse($result, $message)
    {
        return response()->json(['data' => $result, 'message' => $message], 200);
    }

    /**
     * Handle an error response.
     *
     * @param  string  $error
     * @param  array   $errorMessages
     * @param  int     $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    // You can add more common methods as needed
}
