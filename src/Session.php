<?php

namespace Zeretei\PHPCore;

/**
 * TODO: Sanitize session
 */
class Session
{
    protected const FLASH_KEY = 'FLASH_MESSAGE';

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
    public function getAllFlash(): array
    {
        return $_SESSION[static::FLASH_KEY] ?? [];
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
     * Convert flash sessions to removable
     */
    protected function toFlush()
    {
        if (isset($_SESSION[static::FLASH_KEY])) {
            foreach ($_SESSION[static::FLASH_KEY] as $_ => &$message) {
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
    }

    public function __destruct()
    {
        $this->flush();
    }
}
