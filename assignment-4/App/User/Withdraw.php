<?php 
namespace App\User;

use App\Enums\AppType;
use App\User\Transaction;
use App\User\CurrentBalance;
use App\Modeles\WithdrawModel;

class Withdraw extends Transaction
{
    public CurrentBalance $balance;

    public function cliInputs(){
        $msg = "Enter withdraw amount: ";
        printf("\n");
        $this->amount = (float)trim(readline($msg));
        if($this->amount < 0){
            $this->error($this->apptype, "Sorry! your amount not valid.");
            printf("\n");
            return FALSE;
        }
        printf("\n");
        return TRUE;
    }

    public function run(): void
    {
        $this->cliInputs();
        if($this->checkBalance()){
            $this->error($this->apptype, "Sorry! balance not available.");
            return;
        }

        if(($this->apptype == AppType::CLI_APP)){
            $this->service->insertForFile([
                'id' => time(),
                'user_id' => $this->user->getId(),
                'status' => WithdrawModel::getModelName(),
                'amount' => $this->amount,
                'setTransferBy' => 'NULL',
                'created_at' => date('Y-m-d h:i:s')
            ]);
        }else{
            $this->service->insertForDB([
                'user_id' => $this->user->getId(),
                'status' => WithdrawModel::getModelName(),
                'setTransferBy' => 'NULL',
                'amount' => $this->amount
            ]);  
        }
    }

    public function checkBalance(){
        $this->balance = new CurrentBalance($this->apptype);
        $calculateBalance = $this->balance->calculate();
        $realBalance = ($calculateBalance - $this->amount);
        if($realBalance < 0 || $realBalance == 0){
            return TRUE;
        }
        return FALSE;
    }
}