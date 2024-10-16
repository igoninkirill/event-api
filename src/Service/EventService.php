<?php declare(strict_types=1);

namespace App\Service;

use App\DTO\EventDTO;
use App\Message\EventMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;

class EventService
{
    public function __construct(
        protected MessageBusInterface $bus,
        protected SerializerInterface $serializer
    ){}

    public function addEvents(Request $request): bool
    {
        $events = $this->serializer->deserialize($request->getContent(), EventDTO::class . '[]', 'json');
        foreach ($events as $event) {
            $eventMessage = new EventMessage($event->getAccountId(), $event->getEventData());
            $this->bus->dispatch($eventMessage);
        }

        return true;
    }
}
