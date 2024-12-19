<?php

use Illuminate\Http\Exceptions\HttpResponseException;

function hasError($message, $errors = [], $code = 401)
{
    $response = ['success' => false, 'message' => $message];
    if (!empty($errors)) {
        $response['data'] = $errors;
    }

    throw new HttpResponseException(response()->json($response, $code));
}
