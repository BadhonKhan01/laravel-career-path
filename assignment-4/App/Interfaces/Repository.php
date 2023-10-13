<?php
namespace App\Interfaces;

use App\Interfaces\Model;

interface Repository
{
    public function insert(string $model, array $data);
    // public function update(Model $model, array $data);
    // public function delete(Model $model);
    public function get(string $model);
}