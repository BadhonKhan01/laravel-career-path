<?php 
namespace App\Repository;

use App\Database\DB;
use App\Interfaces\Repository;

class TransactionDBRepository implements Repository
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

        $user_id = $data['user_id'];
        $status = $data['status'];
        $amount = $data['amount'];

        $sql = "INSERT INTO $model (id, user_id, status, amount, created_at) VALUES (NULL, '$user_id', '$status', '$amount', NOW())";
        $this->db->insertTable($sql);
        
    }

    public function get($model){
        $this->db->createConnection();

        $sql = "SELECT *  FROM `$model`";
        $deposit = $this->db->getTable($sql);
        var_dump($deposit);

        $userModels = [];
        // foreach ($users as $user) {
        //     $userModel = new UserModel();
        //     $userModel->setId($user["user_id"]);
        //     $userModel->setName($user["name"]);
        //     $userModel->setEmail($user["email"]);
        //     $userModel->setPassword($user["password"]);
        //     $userModel->setAccountType($user["account_type"]);
        //     $userModels[] = $userModel;
        // }
        return $userModels;
    }

}