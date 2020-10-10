<?php
namespace Http;

class Mail
{
    private static $to;
    private static $subject = "Hi.";
    private static $message;
    private static $headers;


    /**
     * Set mail reciever
     */
    public static function to($email)
    {
        static::$to = $email;
        return new static;
    }

    /**
     * Set mail subject
     */
    public static function subject($subject)
    {
        static::$subject = $subject;
        return new static;
    }


    /**
     * Set mail message
     */
    public static function line($msg)
    {
        static::$message .= "{$msg} \n ";
        return new static;
    }

    /**
     * Set message via file
     */
    public static function view($file)
    {
        // TODO: fix on live server
        static::$message = file_get_contents("{$file}.view.php") ;
        return new static;
    }

    /**
     * Set mail headers
     */
    public static function headers($headers)
    {
        static::$headers = $headers;
        return new static;
    }

    /**
     * Set mail file attachments
     */
    public static function attach($file)
    {
        // TODO: implement file attachment
    }

    /**
     * Send mail
     */
    public static function send()
    {
        // TODO: dynamic mail (optional)
        static::$to = implode(",", static::$to);
        mail(static::$to, static::$subject, static::$message, static::$headers);

        // success redirect
    }
}
