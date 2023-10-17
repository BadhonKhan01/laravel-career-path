<?php

namespace App\Modeles;

use App\Interfaces\Model;

class DepositModel implements Model
{
    private int $id;
    private int $userId;
    protected string $createdAt;
    protected string $amount;
    protected string $status;
    protected string $transferBy;

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

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setTransferBy(string $transferBy): void
    {
        $this->transferBy = $transferBy;
    }

    public function getTransferBy(): string
    {
        return $this->transferBy;
    }
}
