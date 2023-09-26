<?php 
namespace App\Classes;

use App\Classes\ModelinterFace;

class User implements ModelinterFace
{
    protected $name = '';
    protected $email = '';
    protected $password = '';
    protected AuthType $type;

    public static function getModelName(): string
    {
        return 'users';
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setName(string $name){
        $this->name = $name;
    }

    public function setEmail(string $email){
        $this->email = $email;
    }

    public function setPassword(string $password){
        $this->password = $password;
    }

    public function getAuthType(){
        return $this->type; 
    }

    public function setAuthType(AuthType $type){
        $this->type = $type;
    }
}
