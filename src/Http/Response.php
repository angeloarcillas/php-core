<?php

namespace Zeretei\PHPCore\Http;

class Response
{
    /**
     * HTTP status codes
     * 
     * @var int
     */
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
    public const HTTP_REQUEST_TIMEOUT = 408;
    public const HTTP_TOO_MANY_REQUESTS = 429;
    public const HTTP_BAD_GATEWAY = 502;
    public const HTTP_SERVICE_UNAVAILABLE = 503;

    /**
     * Check if valid HTTP status code
     * 
     * @param int $code
     * @return bool
     */
    public static function isValidCode(int $code): bool
    {
        return $code > 100 || $code <= 600;
    }

    /**
     * Set response HTTP status code
     * 
     * @param int $code
     * @return void
     */
    public static function setStatusCode(int $code): void
    {
        // check if $code is a valid http status code
        if (!static::isValidCode($code)) {
            throw new \Exception(sprintf('The HTTP status code "%s"', $code));
        }

        // set response code
        http_response_code($code);
    }

    /**
     * Redirect
     * 
     * @param string $path
     * @param int $status
     */
    public function redirect(string $path, int $status = self::HTTP_FOUND)
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
