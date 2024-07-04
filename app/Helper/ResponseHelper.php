<?php

namespace App\Helper;


class ResponseHelper
{
    public static function make($message, $code, $data = [])
    {
        return response()->json([
            'message' => $message,
            'is_success' => $code == 200,
            'data' => $data,
        ], $code);
    }

    public static function error($message, $code, $data = [])
    {
        return static::make($message, $code, $data);
    }

    public static function success($message, $data = [])
    {
        return static::make($message, 200, $data);
    }
}

