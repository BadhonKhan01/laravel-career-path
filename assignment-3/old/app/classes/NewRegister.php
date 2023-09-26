<?php 
namespace App\Classes;

use App\Classes\User;

class NewRegister extends User
{
    function __construct($newUser){
        $this->name = $newUser['name'];
        $this->email = $newUser['name'];
        $this->password = $newUser['password'];
    }
}
