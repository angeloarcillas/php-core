<?php

namespace Zeretei\PHPCore\Http\Traits;

use \Zeretei\PHPCore\Application;
use \Zeretei\PHPCore\Http\Request;

trait Validator
{
    protected static $ERROR_MESSAGES = [
        'required' => 'The {field} is required.',
        'string' => 'The {field} must be a string.',
        'email' => 'Invalid Email Adress.',
        'min' => 'Your {field} is too short, min of {min}.',
        'max' => 'Your {field} is too long, max of {max}.',
        'same' => 'The {field} and {key} did not match.',
        'confirm' => 'The {field} and confirm {field} did not match.',
    ];

    /**
     * input name (<input name="" />)
     */
    protected $input;

    /**
     * Validate input fields with rules
     */
    public function validate(array $fields): ?array
    {
        // validated fields placeholder
        $validated = [];

        // loop through fields
        foreach ($fields as $key => $rules) {
            // check if the user didnt define an input name or a rule
            if (!is_string($key)) {
                throw new \Exception(
                    sprintf('Request "%s" is missing a field or a rule', $rules)
                );
            }

            // field value
            $value = Request::request($key);

            // <input name="$this->input">
            $this->input = $key;

            // check if the current request exists
            if (is_null($value)) {
                throw new \Exception(
                    sprintf('request field "%s" does not exists.', $this->input)
                );
            }

            // if "required|min:6|max:255"  (string with `|`)
            // convert to ["required", "min:6", "max:255"]
            $rules = (!is_string($rules)) ? $rules : explode("|", $rules);

            foreach ($rules as $rule) {
                // execute rule - if true, next field
                if ($this->execute($rule, $value)) break;
            }

            // append validated rules
            $validated[$key] = $value;
        }


        // check if field has error
        $hasError = count(Application::get('session')->errorBag()) > 0;

        // if has error redirect back
        // else return all validated fields
        return (!$hasError) ? $validated : Application::get('router')->back();
    }


    /**
     * Check if request has is set and has a value
     */
    protected function required(string $request): bool
    {
        if (!isset($request) || empty($request)) {
            $this->error('required', ['field' => $this->input]);
            return true;
        }
        return false;
    }

    /**
     * Check if Request is a string
     */
    protected function string(string $request): bool
    {
        if (!is_string($request)) {
            $this->error('string', ['field' => $this->input]);
            return true;
        }

        return false;
    }

    /**
     * Check if rule minimum value meet
     */
    protected function min(string  $request, string $value)
    {
        // check if value has non numeric character
        if (!$this->isNumeric($value)) {
            throw new \Exception('Rule "min" must not contain a non numerical value.');
        }

        // check if input value is less than min rule value
        if (strlen($request) < (int) $value) {
            $this->error('min', ['field' => $this->input, 'min' => $value]);
            return true;
        }

        return false;
    }


    /**
     * Check if rule maximum value didn't exceed
     */
    protected function max(string $request, string $value): bool
    {
        // check if value has non numeric character
        if ($this->isNumeric($value)) {
            throw new \Exception('Rule "max" must not contain a non numerical value.');
        }

        // check if input value is greater than max rule value
        if (strlen($request) > (int) $value) {
            $this->error('max', ['field' => $this->input, 'max' => $value]);
            return true;
        }

        return false;
    }

    /**
     * Check if request is a valid email
     */
    protected function email($request): bool
    {
        // validate if valid email syntax
        if (!$this->isEmail($request)) {
            $this->error('email');
            return true;
        }

        return false;
    }

    /**
     * Check if 2 input is a match
     */
    protected function same(string $request, string $key)
    {
        if (Request::request($key) !== $request) {
            $this->error('same', ['field' => $this->input, 'key' => $key]);
            return true;
        }

        return false;
    }

    /**
     * Check if input and confirm input is a match
     */
    protected function confirm(string $request)
    {
        // ex. password_confirmation / foo_confirmation
        $key = $this->input . '_confirmation';

        // check if 2 value matched
        if (Request::request($key) !== $request) {
            $this->error('confirm', ['field' => $this->input]);
            return true;
        }

        return false;
    }

    /**
     * Check if string $value only contains numeric value
     */
    public function isNumeric(string $value): bool
    {
        return !preg_match('/[^0-9]/', $value);
    }

    /**
     * Check if $value is an email
     */
    public function isEmail(string $email): bool
    {
        // sanitize email
        $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        // validate email
        $isFilterValidEmail = filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL);
        // 3-50 char/. @ 2-12 char . 2-8 char | example.123@mail.com
        $isRegexValidEmail = preg_match('/^[\w\.]{3,50}@\w{2,12}\.\w{2,8}$/', $sanitizedEmail);
        // validate if valid email syntax
        return ($isFilterValidEmail && $isRegexValidEmail);
    }

    /**
     * Set session errors
     */
    protected function error(string $key, array $params = [])
    {
        // get error message
        $message = $this->getErrors()[$key] ?? '';

        // replace wildcard w/ value
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        // set error to session
        Application::get('session')->setErrorFlash($this->input, $message);
    }

    /**
     * All errors
     */
    protected function getErrors(): array
    {
        return static::$ERROR_MESSAGES;
    }

    /**
     * Execute rule
     */
    protected function execute(string $rule, mixed $value): bool
    {
        // get rule and parameter - ['min':5]
        [$rule, $parameter] = [...explode(':', $rule), null];

        // check if rule exists
        if (!method_exists($this::class, $rule)) {
            throw new \Exception(sprintf('Rule "%s" does not exists', $rule));
        }

        // call rule
        return $this->{$rule}($value, $parameter);
    }
}
