<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function failedResponse(
        string $message = 'Operation Encountered An Error!',
        int $statusCode = Response::HTTP_BAD_REQUEST
    ) {
        return response()->json([
            'data' => [
                'message' => $message,
                'result'  => false
            ]
        ], $statusCode);
    }

    public function successResponse(
        array $info = [],
        string $message = 'Operation Has Been Done Successfully.',
        int $statusCode = Response::HTTP_CREATED
    ) {
        $data = ['message' => $message, 'result'  => true];
        if ($info) {
            $data[ 'Info' ] = $info;
        }

        return response()->json(['data' => $data], $statusCode);
    }


}
