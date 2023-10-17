<?php 
namespace App\Database;

use PDO;
use PDOException;


class DB
{

    private static string $hostName = 'localhost';
    private static string $databaseName = 'career_path';
    private static string $userName = 'root';
    private static string $password = '';
    private static ?PDO $conn = null;

    public static function createConnection()
    {
        try {
            self::$conn = new PDO("mysql:host=" . self::$hostName. ";dbname=" . self::$databaseName. "", self::$userName, self::$password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage() . PHP_EOL;
        }
    }

    public function createTable(string $name, string $sql)
    {
        try {
            self::$conn->exec($sql);
            echo "Created $name\n";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getTable($sql){
        try {
            $stmt = self::$conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function insertTable($sql){
        try {
            return self::$conn->exec($sql);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function __destruct()
    {
        self::$conn = null;
    }
}
