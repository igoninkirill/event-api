<?php declare(strict_types=1);

namespace App\Message;

class EventMessage
{
    private int $accountId;
    private string $eventData;

    public function __construct(int $accountId, string $eventData)
    {
        $this->accountId = $accountId;
        $this->eventData = $eventData;
    }

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function getEventData(): string
    {
        return $this->eventData;
    }
}
