<?php

namespace Zeretei\PHPCore;

/**
 * TODO: Sanitize session
 */
class Session
{

    protected const FLASH_KEY = 'flash_bag';
    protected const ERROR_KEY = 'error_bag';

    public function __construct()
    {
        $_SESSION[static::FLASH_KEY] = [];
        $_SESSION[static::ERROR_KEY] = [];
    }

    /**
     * Set a flash session
     */
    public function setFlash(string $key, string $message): void
    {
        $_SESSION[static::FLASH_KEY][$key] = $message;
    }

    /**
     * Return a flash session
     */
    public function getFlash(string $key): string
    {
        return $_SESSION[static::FLASH_KEY][$key] ?? null;
    }

    /**
     * Return all flash session
     */
    public function flashBag(): array
    {
        return $_SESSION[static::FLASH_KEY] ?? [];
    }

    /**
     * Set a error flash session
     */
    public function setErrorFlash(string $key, string $message): void
    {
        $_SESSION[static::ERROR_KEY][$key] = $message;
    }

    /**
     * Return a error flash session
     */
    public function getErrorFlash(string $key): string
    {
        return $_SESSION[static::ERROR_KEY][$key] ?? null;
    }

    /**
     * Return all error flash session
     */
    public function errorBag(): array
    {
        return $_SESSION[static::ERROR_KEY] ?? [];
    }

    /**
     * Set a session
     */
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Return a session
     */
    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Return all session
     */
    public function all()
    {
        return $_SESSION ?? [];
    }


    /**
     * !FIXME: repeated statement
     * TODO: Reseach about removing own item on loop
     * 
     * Flush all removable flash sessions
     */
    protected function flush()
    {
        foreach ($_SESSION[static::FLASH_KEY] as $key => &$message) {
            unset($_SESSION[static::FLASH_KEY][$key]);
        }

        foreach ($_SESSION[static::ERROR_KEY] as $key => &$message) {
            unset($_SESSION[static::ERROR_KEY][$key]);
        }
    }

    public function __destruct()
    {
        $this->flush();
    }
}
