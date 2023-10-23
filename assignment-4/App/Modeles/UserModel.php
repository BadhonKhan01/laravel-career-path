<?php

namespace App\Modeles;

use App\Enums\UserType;
use App\Interfaces\Model;

class UserModel implements Model
{
    private int $id;
    private $accountType;
    private string $name;
    private string $email;
    private string $password;
    // private UserType $type;

    public static function getModelName(): string
    {
        return 'users';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAccountType()
    {
        return $this->accountType;
    }

    public function setAccountType($accountType): void
    {
        $this->accountType = $accountType;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    // public function getType(): UserType 
    // {
    //     return $this->type;
    // }

    // public function setType(UserType $type): void 
    // {
    //     $this->type = $type;
    // }
}