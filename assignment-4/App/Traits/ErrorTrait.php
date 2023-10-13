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
            echo "\n $msg \n";
        }
    }
}
