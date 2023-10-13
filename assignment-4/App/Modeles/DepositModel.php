<?php

namespace App\Modeles;

use App\Interfaces\Model;

class DepositModel implements Model
{
    private int $id;
    private int $userId;
    protected string $time;
    protected string $amount;
    protected string $status;

    public static function getModelName(): string
    {
        return 'deposits';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
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
