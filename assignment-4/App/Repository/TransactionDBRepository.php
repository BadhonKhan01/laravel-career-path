<?php 
namespace App\Repository;

use App\Database\DB;
use App\DTO\WebStatus;
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
        $amount = $data['amount'];
        $setTransferBy = $data['setTransferBy'];

        $sql = "INSERT INTO $model (id, user_id, status, amount, setTransferBy, created_at) VALUES (NULL, '$user_id', '$status', '$amount','$setTransferBy', NOW())";
        if($this->db->insertTable($sql)){
            if(!empty($setTransferBy) && $setTransferBy != 'NULL'){
                WebStatus::setStatus(true);
                WebStatus::setStatusMessage("Transfer successfully");
            }else{
                WebStatus::setStatus(true);
                WebStatus::setStatusMessage(ucfirst($model) . " successfully");
            }
        }
        
    }

    public function get($model){
        $this->db->createConnection();

        $modelName = $model::getModelName();
        $sql = "SELECT *  FROM `$modelName`";
        $dbData = $this->db->getTable($sql);
        $getDBArray = [];

        foreach ($dbData as $data) {
            $newModel = new $model();
            $newModel->setId($data["id"]);
            $newModel->setUserId($data["user_id"]);
            $newModel->setAmount($data["amount"]);
            $newModel->setTransferBy($data["setTransferBy"]);
            $newModel->setStatus($data["status"]);
            $newModel->setCreatedAt($data["created_at"]);
            $getDBArray[] = $newModel;
        }
        
        return $getDBArray;
    }

}