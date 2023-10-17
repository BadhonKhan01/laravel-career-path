<?php 
namespace App\Repository;

use App\Interfaces\Repository;

class TransactionFileRepository implements Repository
{
    public function getModelPath(string $model){
        return 'app/data/' . $model . ".txt";
    }

    public function insert(string $model, array $data){
        if(file_put_contents($this->getModelPath($model), serialize($data))){
            printf("%s\n", ucfirst($model)." saved");
        }
    }

    public function get(string $model){
        $data = [];
        if (file_exists($this->getModelPath($model))) {
            $data = unserialize(file_get_contents($this->getModelPath($model)));
        }
        if (!is_array($data)) {
            return [];
        }

        return $data;
    }

}