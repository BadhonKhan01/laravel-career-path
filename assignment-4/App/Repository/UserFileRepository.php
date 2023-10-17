<?php 
namespace App\Repository;

use App\Interfaces\Model;
use App\Interfaces\Repository;

class UserFileRepository implements Repository
{
    public function getModelPath(string $modal){
        return 'app/data/' . $modal . ".txt";
    }

    public function insert(string $model, array $data){
        if(file_put_contents($this->getModelPath($model), serialize($data))){
            printf("\n");
            printf("%s\n", ucfirst($model)." created");
        }
    }

    public function update(Model $model, array $data)    {

    }

    public function delete(Model $model){

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