<?php

namespace Utils;

use \Psr\Http\Message\ResponseInterface as Response;

class ResponseUtil
{
    public static function json(Response $response, $message = "Success", $data = null, $code = 200, $error = null)
    {
        $status = false;
        if ($code >= 200 && $code <= 299) {
            $status = true;
        }
        $res = [
            "status" => $status,
            "message" => $message,
            "data" => $data
        ];
        if ($error != null) {
            $res["error"] = $error;
        }
        $response->getBody()->write(json_encode($res));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($code);
    }
}
