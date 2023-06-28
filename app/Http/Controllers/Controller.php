<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;

class Controller extends BaseController
{
    public function validations($request, $rules)
    {
        $messages = [
            'required'  => 'The :attribute field is required.',
            'unique'  => 'The :attribute field is unique.',
            'password.min' => 'The :attribute must be at least 4 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'code' => 401,
            ], 401);
        }
    }

    public function responeBasic($status, $message, $code, $data = null)
    {
        if ($data != null) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'code' => $code,
                'data' => $data,
            ], $code);
        } else {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'code' => $code,
            ], $code);
        }
    }
}
