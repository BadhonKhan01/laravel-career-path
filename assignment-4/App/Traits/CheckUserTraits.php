<?php 
namespace App\Traits;

use App\Modeles\UserModel;
use App\Traits\Redirect;

trait CheckUserTraits
{
    use Redirect;
    protected function loginUser() {
        if (isset($_SESSION["user_data"]) && isset($_SESSION["expire_time"]) && time() < $_SESSION["expire_time"]) {

            $user = json_decode($_COOKIE["user_data"], true);
            
            $userModel = new UserModel();
            $userModel->setId($user["id"]);
            $userModel->setName($user["name"]);
            $userModel->setEmail($user["email"]);

            return $userModel;
        }else if (isset($_COOKIE["user_data"])) {

            $user = json_decode($_COOKIE["user_data"], true);
            $userModel = new UserModel();
            $userModel->setId($user["id"]);
            $userModel->setName($user["name"]);
            $userModel->setEmail($user["email"]);

            return $userModel;
        }else{
            $this->redirect('/login');
        }
    }
}
