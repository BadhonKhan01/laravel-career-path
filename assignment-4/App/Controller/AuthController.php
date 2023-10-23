<?php 
namespace App\Controller;

use App\Auth\Login;
use App\DTO\WebStatus;
use App\Enums\AppType;
use App\Enums\UserType;
use App\Traits\Redirect;
use App\Auth\Registration;
use App\Traits\FlashTrait;
use App\Traits\ViewTraits;

class AuthController
{
    use ViewTraits;
    use FlashTrait;
    use Redirect;
    private Login $login;
    private Registration $registration;

    
    public function register(){
        $this->view('auth/register');
    }

    public function create(){
        $this->registration = new Registration(AppType::WEB_APP, UserType::USER_ACCOUNT);
        $this->registration->run();

        $this->flashMessage('message',WebStatus::getStatusMessage());

        $this->redirect('/');
    }

    public function login(){
        if(isset($_POST) && !empty($_POST)){
            $this->login = new Login(AppType::WEB_APP, UserType::USER_ACCOUNT);

            $isLogin = $this->login->run();
            if(WebStatus::getError()){
                $this->flashMessage('message',WebStatus::getStatusMessage());
                $this->redirect('/login');
            }

        }else{
            $this->view('auth/login');
        }
    }

    public function logout(){
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time() - 3600, '/');
            }
        }
        session_unset();
        session_destroy();
        $this->redirect('/login');
    }
}

