<?php 
namespace App\Traits;

trait DisplayMenu
{
    public function loadMenus(array $menus): void
    {
        if(!empty($menus)){
            printf("\n");
            foreach($menus as $option => $val){
                printf("%d. %s\n", $option, $val);
            }
            printf("\n");
        }
    }
}
