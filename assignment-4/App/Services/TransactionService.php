<?php 
namespace App\Services;

use App\Enums\AppType;
use App\Modeles\DepositModel;
use App\Interfaces\Repository;
use App\Repository\DepositDBRepository;
use App\Repository\DepositFileRepository;

class TransactionService
{
    public array $deposit;
    public Repository $depositRepository;

    function __construct(AppType $apptype){
        if ($apptype == AppType::CLI_APP) {
            $this->depositRepository = new DepositFileRepository();
        }else{
            $this->depositRepository = new DepositDBRepository();
        }
    }

    public function insertForFile(array $data){
        $diposit = new DepositModel();
        $diposit->setId($data['id']);
        $diposit->setUserId($data['user_id']);
        $diposit->setStatus($data['status']);
        $diposit->setAmount($data['amount']);
        $this->deposit[] = $diposit;
        $this->depositRepository->insert(DepositModel::getModelName(), $this->deposit);
    }

    public function insertForDB(array $data){
        $this->depositRepository->insert(DepositModel::getModelName(), $data);
    }
}