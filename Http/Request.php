<?php
namespace Http;

use Exception;

class Request
{
    protected $attributes;

    public function __construct() {
      $this->attributes = array_map(function ($request) {
          return strip_tags(htmlspecialchars($request));
        }, $_REQUEST);
    }

    /**
     * @return string Request url w/out ?(Query string)
     */
    public static function uri(): string
    {
      return reset(...[explode('?',
        trim($_SERVER['REQUEST_URI'], '/')
      )]);
    }

    /**
     * @return string Request method
     */
    public static function method(): string
    {
      return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string Request variables
     */
    public static function request(): object
    {
      if (empty($_REQUEST))
          throw new Exception("Error: Empty request");

        return $this;
    }

    /**
     * @return mixed GET request
     */
    public static function query(?string $key = null)
    {
      if (!$key)
          return $_GET;

      if (array_key_exists($key, $_GET))
          return $_GET[$key];

      throw new Exception("Query {$key} doesnt exist");
    }

    /**
     * php __get magic method
     */
    public function __get($key)
    {
      if (! $this->attributes[$key])
        return null;
      // throw new \Exception("Error: Request key doesnt exists.");

      return $this->attributes[$key];
    }
}
