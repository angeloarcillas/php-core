<?php

// TODO: convert variables to html
// return view('file', [attr]);
class HTMLParser
{
    protected static $html = '';

    // $html->appendHtml($header)->appendHtml($content)->appendHtml($footer);
    public function appendHtml($str)
    {
        self::$html .= $str;
        return $this;
    }

    public function bracesToPHPTag()
    {
        str_replace('{{', '<?php', self::$html);
        str_replace('}}', '?>', self::$html);


    }

    public function render()
    {
        $this->bracesToPHPTag();
        return require_once self::$html;
    }
}
