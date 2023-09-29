<?php 
namespace App\Trait;

trait UserTrait
{
    public function userInputValidation($data){
        $errors = [];
        if(isset($data['name']) && empty($data['name'])){
            $errors[] = "Name is required!";
        }
        if(isset($data['password']) && empty($data['password'])){
            $errors[] = "Password is required!";
        }
        if (isset($data['email']) &&  empty($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email is required!";
            }
        }

        if (!empty($errors)) {
            printf("\n");
            foreach ($errors as $item) {
                printf("$item\n");
            }
            printf("\n");
            unset($errors);
            return FALSE;
        }else{
            return TRUE;
        }
    }
}
