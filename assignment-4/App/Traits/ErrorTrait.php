<?php 
namespace App\Traits;

use App\Enums\AppType;

trait ErrorTrait
{
    public function error(AppType $apptype, string $msg): void
    {
        if($apptype == AppType::CLI_APP){
            printf("\n");
                printf($msg."\n");
            printf("\n");
        }else{
            if(isset($_SERVER['HTTP_REFERER'])){
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }
}
