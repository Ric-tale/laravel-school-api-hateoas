<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\CollectionJson;

class ApiController extends Controller
{
    use CollectionJson;

    protected function success($data, $statusCode = 200, $message = 'success')
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'status_code' => $statusCode
        ], $statusCode);
    }

    protected function failedResponse($message, $statusCode = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => null,
            'status_code' => $statusCode
        ], $statusCode);
    }
}
