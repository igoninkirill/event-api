<?php declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class EventDTO implements DTO
{
    #[Assert\NotBlank]
    private int $accountId;

    #[Assert\NotBlank]
    private string $eventData;

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function setAccountId(int $accountId): static
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getEventData(): string
    {
        return $this->eventData;
    }

    public function setEventData(string $eventData): static
    {
        $this->eventData = $eventData;

        return $this;
    }
}
