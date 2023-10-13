<?php 
namespace App\User;

use App\Enums\AppType;
use App\User\Transaction;
use App\Modeles\DepositModel;

class DepositMoney extends Transaction
{
    public function run(): void
    {
        if(($this->apptype == AppType::CLI_APP) && $this->cliInputs()){
            $this->service->insertForFile([
                'id' => time(),
                'user_id' => $this->user->getId(),
                'status' => DepositModel::getModelName(),
                'amount' => $this->amount
            ]);
        }else{
            if($this->cliInputs()){
                $this->service->insertForDB([
                    'user_id' => $this->user->getId(),
                    'status' => DepositModel::getModelName(),
                    'amount' => $this->amount
                ]); 
            }  
        }
    }
}