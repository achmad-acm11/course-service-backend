<?php

use Illuminate\Support\Facades\Http;

function getUser($userId)
{
    $url = env("SERVICE_USER_URL") . "user/" . $userId;
    try {
        $response = Http::timeout(10)->get($url);
        $data = $response->json();
        $data["http_code"] = $response->getStatusCode();
        return $data;
    } catch (\Throwable $th) {
        return [
            "message" => 'Service user unavailable',
            "status" => "error",
            "code" => 500
        ];
    }
}
