<?php 
namespace App\DTO;

class TransactionType
{
    private static mixed $objectName;
    
    public static function setModel($model): void
    {
        self::$objectName = $model;
    }

    public static function getModel(): object
    {
        return self::$objectName;
    }
}
