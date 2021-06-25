<?php

namespace Zeretei\PHPCore\Http;

class Response
{
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_NO_CONTENT = 204;
    public const HTTP_MOVED_PERMANENTLY = 301;
    public const HTTP_FOUND = 302;
    public const HTTP_TEMPORARY_REDIRECT = 307;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
    public const HTTP_REQUEST_TIMEOUT = 408;                                         // RFC6585
    public const HTTP_TOO_MANY_REQUESTS = 429;
    public const HTTP_BAD_GATEWAY = 502;
    public const HTTP_SERVICE_UNAVAILABLE = 503;


    public static function isValidCode($code)
    {
        return $code > 100 || $code <= 600;
    }

    public static function setStatusCode($code)
    {
        if (!static::isValidCode($code)) {
            throw new \Exception(sprintf('The HTTP status code "%s"', $code));
        }

        http_response_code($code);
    }

    public function redirect($path, $status = self::HTTP_FOUND)
    {
        // check if any header already sent
        if (!headers_sent()) {
            // convert dot to forward slash
            $realSubPath = str_replace('.', '/', $path);
            // trim excess forward slash
            $realPath = trim($realSubPath, '/');
            // redirect
            header("location:/{$realPath}", true, $status);
            exit;
        }
    }
}
