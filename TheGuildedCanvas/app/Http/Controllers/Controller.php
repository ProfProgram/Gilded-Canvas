<?php

namespace App\Http\Controllers;

abstract class Controller
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
