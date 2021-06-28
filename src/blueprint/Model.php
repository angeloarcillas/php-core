<?php

namespace Zeretei\PHPCore\Blueprint;

abstract class Model
{
    protected string $table;
    protected array $fillable = [];
    protected string $key = 'id';

    public function __construct()
    {;
        if (!isset($this->table)) {
            $this->table = $this->getBaseClassname() . 's';
        }
    }

    /**
     * Filter $request with $this->fillable
     * Returns all request that can be filled
     * 
     * @param array $params
     * @return array
     */
    protected function filter(array $params): array
    {
        return array_filter(
            // request
            $params,

            // arrow function | return fillable requests
            fn ($_, $key) => in_array($key, $this->fillable),

            // use array keys & values
            ARRAY_FILTER_USE_BOTH
        );
    }

    /**
     * Get base classname
     */
    protected function getBaseClassname()
    {
        $class = get_called_class();
        $base = basename(str_replace('\\', DIRECTORY_SEPARATOR, $class));
        return  strtolower($base);
    }
}
