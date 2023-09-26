<?php 
namespace App\Auth;

use App\Interface\Model;
use App\Enum\UserType;

class User implements Model
{
    private $name;
    private $email;
    private $password;
    protected UserType $type;

    public static function getModelName(): string
    {
        return 'users';
    }

    public function setName(string $name): void 
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void 
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void 
    {
        $this->password = $password;
    }

    public function setType(UserType $type): void 
    {
        $this->type = $type;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getEmail(): string 
    {
        return $this->email;
    }

    public function getPassword(): string 
    {
        return $this->password;
    }
    
    public function getType(): UserType 
    {
        return $this->type;
    }

    
}
