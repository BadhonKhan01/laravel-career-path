<?php 
namespace App\Classes;

interface StorageInterFace
{
    public function load(string $model): array;
}