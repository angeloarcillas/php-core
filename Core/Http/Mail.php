<?php
namespace Http;

/**
 * Work in progress
 */
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
        self::$to = $email;
        return new self;
    }

    /**
     * Set mail subject
     */
    public static function subject($subject)
    {
        self::$subject = $subject;
        return new self;
    }


    /**
     * Set mail message
     */
    public static function line($msg)
    {
        self::$message .= "{$msg} \n ";
        return new self;
    }

    /**
     * Set message via file
     */
    public static function view($file)
    {
        // TODO: fix on live server
        self::$message = view("mail/{$file}");
        return new self;
    }

    /**
     * Set mail headers
     */
    public static function headers($headers)
    {
        self::$headers = $headers;
        return new self;
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
        mail(self::$to, self::$subject, self::$message, self::$headers);

        // success redirect
    }
}
