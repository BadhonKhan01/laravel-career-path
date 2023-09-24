<?php 
namespace App\Classes;

use App\Classes\StorageInterFace;

class FileStorage implements StorageInterFace
{
    public function save($model, $data){
        file_put_contents($this->getModelPath($model), serialize($data));
    }

    public function load($model): array {
        if (file_exists($this->getModelPath($model))) {
            $data = unserialize(file_get_contents($this->getModelPath($model)));
        }
        if (!is_array($data)) {
            return [];
        }

        

        return $data;
    }
    
    public function getModelPath($model): string {
        return 'app/data/' . $model . ".txt";
    }
}
