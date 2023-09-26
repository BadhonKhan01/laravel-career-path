<?php 
namespace App\Storage;

use App\Interface\Storage;

class FileStorage implements Storage
{
    private $data;

    public function save(string $model, array $data): void
    {
        file_put_contents($this->getModelPath($model), serialize($data));
    }

    public function load(string $model): array 
    {
        $this->data = [];
        if (file_exists($this->getModelPath($model))) {
            $this->data = unserialize(file_get_contents($this->getModelPath($model)));
        }

        if (!is_array($this->data) && !empty($this->data)) {
            return [];
        }

        return $this->data;
    }

    public function getModelPath(string $model): string
    {
        return "data/{$model}.text";
    }

}
