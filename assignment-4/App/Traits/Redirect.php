<?php 
namespace App\Traits;

trait Redirect
{
    public function back() {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function redirect($location){
        $url = $_SERVER['HTTP_ORIGIN'] . $location;
        header("Location:$url");
    }
}
