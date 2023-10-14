<?php 
namespace App\User;

use App\Enums\AppType;
use App\User\Transaction;
use App\Modeles\WithdrawModel;

class Withdraw extends Transaction
{
    public function cliInputs(){
        $msg = "Enter withdraw amount: ";
        $this->amount = (float)trim(readline($msg));
        if($this->amount < 0){
            $this->error($this->apptype, "Sorry! your amount not valid.");
            return FALSE;
        }
        return TRUE;
    }

    public function run(): void
    {
        if(($this->apptype == AppType::CLI_APP) && $this->cliInputs()){
            $this->service->insertForFile([
                'id' => time(),
                'user_id' => $this->user->getId(),
                'status' => WithdrawModel::getModelName(),
                'amount' => $this->amount,
                'created_at' => date('Y-m-d h:i:s')
            ]);
        }else{
            if($this->cliInputs()){
                $this->service->insertForDB([
                    'user_id' => $this->user->getId(),
                    'status' => WithdrawModel::getModelName(),
                    'amount' => $this->amount
                ]); 
            }  
        }
    }
}