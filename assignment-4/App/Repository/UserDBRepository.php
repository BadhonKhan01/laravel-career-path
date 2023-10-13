<?php 
namespace App\Repository;

use App\Database\DB;
use App\Interfaces\Model;
use App\Modeles\UserModel;
use App\Interfaces\Repository;

class UserDBRepository implements Repository
{
    public DB $db;

    public function __construct()
    {
        $this->db = new DB();
        $this->db->createConnection();
    }
    
    public function getModelPath(string $modal){
        return 'app/data/' . $modal . ".txt";
    }

    public function insert(string $model, array $data){
        $this->db->createConnection();
        
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $accountType = $data['account_type'];

        $sql = "INSERT INTO $model (id, name, email, password, account_type, created_at) VALUES (NULL, '$name', '$email', '$password', '$accountType', NOW())";
        $this->db->insertTable($sql);
        
    }

    public function update(Model $model, array $data)    {

    }

    public function delete(Model $model){

    }

    public function get($model){
        $this->db->createConnection();

        $sql = "SELECT *  FROM `$model`";
        $users = $this->db->getTable($sql);

        $userModels = [];
        foreach ($users as $user) {
            $userModel = new UserModel();
            $userModel->setId($user["id"]);
            $userModel->setName($user["name"]);
            $userModel->setEmail($user["email"]);
            $userModel->setPassword($user["password"]);
            $userModel->setAccountType($user["account_type"]);
            $userModels[] = $userModel;
        }
        return $userModels;
    }

}