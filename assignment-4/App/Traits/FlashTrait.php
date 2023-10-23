<?php 
namespace App\Traits;

trait FlashTrait
{
    protected function flashMessage($key, $msg) {
        $_SESSION[$key] = $msg;
    }
}
