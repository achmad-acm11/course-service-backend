<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;

class Url
{
    static public function getUser($usersId)
    {
        $url = env("SERVICE_USER_URL") . "user/" . $usersId;

        try {
            $response = Http::timeout(10)->get($url);

            $data = $response->json();
            $data['http_code'] = $response->getStatusCode();
            return $data;
        } catch (\Throwable $th) {
            return [
                "status" => "error",
                "http_code" => 500,
                "message" => "service user unavailable"
            ];
        }
    }
    static public function getUserByIds($usersIds = [])
    {
        $url = env("SERVICE_USER_URL") . "user/";
        try {
            if (count($usersIds) == 0) {
                return [
                    "status" => 'success',
                    "http_code" => 200,
                    "data" => []
                ];
            }

            $response = Http::timeout(10)->get($url, ["user_ids[]" => $usersIds]);
            $data = $response->json();
            $data['http_code'] = $response->getStatusCode();
            return $data;
        } catch (\Throwable $th) {
            return [
                "status" => "error",
                "http_code" => 500,
                "message" => "service user unavailable"
            ];
        }
    }
}
