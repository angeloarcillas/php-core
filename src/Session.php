<?php

namespace Zeretei\PHPCore;

class Session
{
    /**
     * Session flash messages key
     * 
     * @var string
     */
    protected const FLASH_KEY = 'flash_bag';

    /**
     * Session error messages key
     * 
     * @var string
     */
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
        $message = filter_var($message, FILTER_SANITIZE_STRING);

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
     * Return all flash session - key & value only
     */
    public function flashBag(): array
    {
        $flash =  $_SESSION[static::FLASH_KEY] ?? [];

        foreach ($flash as $key => $value) {
            $flash[$key] = $value['value'];
        }

        return $flash;
    }

    /**
     * Set a error flash session
     */
    public function setErrorFlash(string $key, string $message): void
    {
        $message = filter_var($message, FILTER_SANITIZE_STRING);

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
     * Return all error flash session - key & value only
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
        if (is_string($value)) {
            $value = filter_var($value, FILTER_SANITIZE_STRING);
        }

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
     * Convert all flash sessions to removable
     */
    protected function toFlush(): void
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
     * Flush all removable flash sessions
     */
    protected function flush(): void
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
