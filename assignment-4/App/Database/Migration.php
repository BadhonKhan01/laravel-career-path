<?php
namespace App\Database;

use PDO;
use App\Database\DB;

class Migration
{
    public DB $db;

    public function __construct()
    {
        $this->db = new DB();
        $this->db->createConnection();
    }

    public function run(): void
    {
        $files = glob(__DIR__ . "/migrations/*");
        foreach ($files as $file) {
            if (is_file($file)) {
                $name = str_replace('.sql','',ucfirst(basename($file)));
                $sql = file_get_contents($file);
                $this->db->createTable($name, $sql);
            }
        }
    }
}
