<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    public function __construct(protected EventService $service)
    {}

    #[Route('/api/events', name: 'api_events', methods: ['POST'])]
    public function addEvents(Request $request): JsonResponse
    {
        $this->service->addEvents($request);
        return new JsonResponse(['status' => 'Events added to the queue'], 200);
    }
}
