<?php 
namespace App\Services;

use App\Enums\AppType;
use App\Modeles\UserModel;
use App\Interfaces\Repository;
use App\Repository\UserDBRepository;
use App\Repository\UserFileRepository;

class UserService
{
    public array $users;
    public Repository $userRepository;

    function __construct(AppType $apptype){
        if ($apptype == AppType::CLI_APP) {
            $this->userRepository = new UserFileRepository();
        }else{
            $this->userRepository = new UserDBRepository();
        }
        $this->users = $this->userRepository->get(UserModel::getModelName());
    }

    public function insertForFile(array $data){
        $newUser = new UserModel();
        $newUser->setId($data['id']);
        $newUser->setAccountType($data['accountType']);
        $newUser->setName($data['name']);
        $newUser->setEmail($data['email']);
        $newUser->setPassword($data['password']);
        $this->users[] = $newUser;
        $this->userRepository->insert(UserModel::getModelName(), $this->users);
    }

    public function insertForDB(array $data){
        $this->userRepository->insert(UserModel::getModelName(), $data);
    }
}