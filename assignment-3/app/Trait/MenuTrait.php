<?php 
namespace App\Trait;

trait MenuTrait
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
