<?php 
namespace App\User;

use App\Enums\AppType;
use App\Modeles\DepositModel;
use App\Interfaces\Repository;
use App\Modeles\WithdrawModel;
use App\Repository\TransactionFileRepository;

class ShowTransactions
{
    public array $deposit;
    public array $withdraw;
    public Repository $depositRepository;
    public Repository $withdrawRepository;

    function __construct()
    {
        $this->depositRepository = new TransactionFileRepository();
        $this->deposit = $this->depositRepository->get(DepositModel::getModelName());

        $this->withdrawRepository = new TransactionFileRepository();
        $this->withdraw = $this->withdrawRepository->get(WithdrawModel::getModelName());        
    }
    
    public function run(): void
    {
        $result = array_merge($this->deposit, $this->withdraw);
        usort($result, function($a, $b) {
            return strtotime($a->getCreatedAt()) - strtotime($b->getCreatedAt());
        });
        foreach($result as $item){
            printf("%s - %s - %s\n", $item->getCreatedAt(), $item->getAmount(), $item->getStatus());
        }
    }
}