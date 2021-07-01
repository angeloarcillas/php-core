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
        $this->toFlush();
    }

    /**
     * Set a flash session
     */
    public function setFlash(string $key, string $message): void
    {
        $_SESSION[static::FLASH_KEY][$key] = [
            'value' => $message,
            'remove' => false
        ];
    }

    /**
     * Return a flash session
     */
    public function getFlash(string $key): string
    {
        return $_SESSION[static::FLASH_KEY][$key]['value'] ?? null;
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
        $_SESSION[static::ERROR_KEY][$key] = [
            'value' => $message,
            'remove' => false
        ];
    }

    /**
     * Return a error flash session
     */
    public function getErrorFlash(string $key): string
    {
        return $_SESSION[static::ERROR_KEY][$key]['value'] ?? null;
    }

    /**
     * Return all error flash session
     */
    public function errorBag(): array
    {
        // create a copy of session
        $errors = $_SESSION[static::ERROR_KEY] ?? [];

        // flatten array
        foreach ($errors as $key => $value) {
            $errors[$key] = $value['value'];
        }

        // return all errors
        return $errors;
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
     * TODO: learn why property remove is need
     * 
     * Convert flash sessions to removable
     */
    protected function toFlush()
    {
        if (isset($_SESSION[static::FLASH_KEY])) {
            foreach ($_SESSION[static::FLASH_KEY] as $_ => &$message) {
                $message['remove'] = true;
            }
        }

        if (isset($_SESSION[static::ERROR_KEY])) {
            foreach ($_SESSION[static::ERROR_KEY] as $_ => &$message) {
                $message['remove'] = true;
            }
        }
    }

    /**
     * TODO: Reseach about removing own item on loop
     * 
     * Flush all removable flash sessions
     */
    protected function flush()
    {
        if (isset($_SESSION[static::FLASH_KEY])) {
            foreach ($_SESSION[static::FLASH_KEY] as $key => &$message) {
                if ($message['remove']) {
                    unset($_SESSION[static::FLASH_KEY][$key]);
                }
            }
        }

        if (isset($_SESSION[static::ERROR_KEY])) {
            foreach ($_SESSION[static::ERROR_KEY] as $key => &$message) {
                if ($message['remove']) {
                    unset($_SESSION[static::ERROR_KEY][$key]);
                }
            }
        }
    }

    public function __destruct()
    {
        $this->flush();
    }
}
