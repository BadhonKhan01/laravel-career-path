<?php 
namespace App\Interfaces;

interface Model{
    public static function getModelName(): string;
    public function getId(): int;
}