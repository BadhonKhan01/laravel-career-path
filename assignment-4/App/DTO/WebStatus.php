<?php 
namespace App\DTO;

class WebStatus
{
    private static $status;
    private static $message;
    private static $error = FALSE;
    
    public static function setStatus($status)
    {
        self::$status = $status;
    }

    public static function getStatus()
    {
        return self::$status;
    }

    public static function setStatusMessage(string $message)
    {
        self::$message = $message;
    }

    public static function getStatusMessage()
    {
        return self::$message;
    }

    public static function setError($error)
    {
        self::$error = $error;
    }

    public static function getError()
    {
        return self::$error;
    }
}
