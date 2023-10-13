<?php 
namespace App\Traits;

use App\Enums\UserType;

trait AccountType
{
    function getUserType($type) {
        switch ($type) {
            case UserType::USER_ACCOUNT:
                    return "USER_ACCOUNT";
                break;
            case UserType::ADMIN_ACCOUNT:
                    return "ADMIN_ACCOUNT";
                break;
        }
    }
}
