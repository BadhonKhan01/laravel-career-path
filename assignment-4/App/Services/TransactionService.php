<?php 
namespace App\Services;

use App\Enums\AppType;
use App\Interfaces\Model;
use App\DTO\TransactionType;
use App\Interfaces\Repository;
use App\Repository\TransactionDBRepository;
use App\Repository\TransactionFileRepository;

class TransactionService
{
    public array $storage;
    public Repository $repository;
    public Model $model;

    function __construct(AppType $apptype){

        $this->model = TransactionType::getModel();

        if ($apptype == AppType::CLI_APP) {
            $this->repository = new TransactionFileRepository();
            $this->storage = $this->repository->get($this->model::getModelName());
        }else{
            $this->repository = new TransactionDBRepository();
        }
    }

    public function insertForFile(array $data){
        $this->model->setId($data['id']);
        $this->model->setUserId($data['user_id']);
        $this->model->setStatus($data['status']);
        $this->model->setAmount($data['amount']);
        $this->storage[] = $this->model;
        $this->repository->insert($this->model::getModelName(), $this->storage);
    }

    public function insertForDB(array $data){
        $this->repository->insert($this->model::getModelName(), $data);
    }
}