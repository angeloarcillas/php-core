<?php

class Session
{
    protected const FLASH_KEY = 'flash_message';

    public function setFlash($key, $value, $keep = false)
    {
        $_SESSION[static::FLASH_KEY][$key] = $value;
    }
    public function getFlash($key)
    {
        return $_SESSION[static::FLASH_KEY][$key];
    }
    public function set($key, $value, $keep = false)
    {
        $_SESSION[$key] = $value;
    }
    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function __construct()
    {
        // check if changes persist
        foreach ($_SESSION[self::FLASH_KEY] as $key => &$session_message) {
            // attribute to check if removable
            // if ($session_message['removable']) {
            $session_message['remove'] = true;
            // }
        }
    }

    public function __destruct()
    {
        foreach ($_SESSION[self::FLASH_KEY] as $key => $session_message) {
            if ($session_message['remove']) {
                unset($_SESSION[self::FLASH_KEY][$key]);
            }
        }
    }
}
