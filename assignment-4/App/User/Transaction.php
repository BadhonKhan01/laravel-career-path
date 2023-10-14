<?php 
namespace App\User;

use App\Enums\AppType;
use App\Modeles\UserModel;
use App\Traits\ErrorTrait;
use App\Services\TransactionService;

abstract class Transaction
{
    use ErrorTrait;
    public AppType $apptype;
    public UserModel $user;
    public float $amount;

    public $service;

    function __construct(AppType $apptype, UserModel $user)
    {
        $this->apptype = $apptype;
        $this->user = $user;
        $this->service = new TransactionService($this->apptype);
    }

    abstract public function cliInputs();

    abstract public function run();
}