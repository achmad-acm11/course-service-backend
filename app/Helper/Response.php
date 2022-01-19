<?php

namespace App\Helper;

class Response
{
    static public function apiResponse($message, $status, $code, $data)
    {
        return [
            "meta" => [
                "message" => $message,
                "status" => $status,
                "code" => $code
            ],
            "data" => $data
        ];
    }
    static public function apiResponseNotFound($message)
    {
        return [
            "meta" => [
                "message" => "Not found",
                "status" => "error",
                "code" => 404
            ],
            "data" => [
                "message" => $message
            ]
        ];
    }
    static public function apiResponseBadRequest($data)
    {
        return [
            "meta" => [
                "message" => "Bad request",
                "status" => "error",
                "code" => 400
            ],
            "data" => $data
        ];
    }
    static public function apiResponseConflict($message)
    {
        return [
            "meta" => [
                "message" => "Conflict",
                "status" => "error",
                "code" => 409
            ],
            "data" => [
                "message" => $message
            ]
        ];
    }
    static public function apiResponseMethodNotAllowed($message)
    {
        return [
            "meta" => [
                "message" => "Method Not Allowed",
                "status" => "error",
                "code" => 405
            ],
            "data" => [
                "message" => $message
            ]
        ];
    }
}
