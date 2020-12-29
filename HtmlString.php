<?php
class HtmlString
{
    public $html;

    public function __construct(public string $html = '') {}

    public function __toString()
    {
        return $this->html;
    }

    public function isEmpty()
    {
        return $this->html === '';
    }
}
