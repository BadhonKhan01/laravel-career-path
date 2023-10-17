<?php 
namespace App\User;

use App\Enums\AppType;
use App\User\Transaction;
use App\Modeles\DepositModel;

class Deposit extends Transaction
{
    public function cliInputs(){
        $msg = "Enter deposit amount: ";
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

        if(($this->apptype == AppType::CLI_APP)){
            $this->service->insertForFile([
                'id' => time(),
                'user_id' => $this->user->getId(),
                'status' => DepositModel::getModelName(),
                'amount' => $this->amount,
                'setTransferBy' => 'NULL',
                'created_at' => date('Y-m-d h:i:s')
            ]);
        }else{
            $this->service->insertForDB([
                'user_id' => $this->user->getId(),
                'status' => DepositModel::getModelName(),
                'setTransferBy' => 'NULL',
                'amount' => $this->amount
            ]); 
        }
    }
}