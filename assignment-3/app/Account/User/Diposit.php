<?php 
namespace App\Account\User;

use App\Interface\Model;

class Diposit implements Model
{
    protected string $time;
    protected string $amount;
    protected string $status;

    public static function getModelName(): string
    {
        return 'diposit';
    }

    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setTime(string $time): void
    {
        $this->time = $time;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
