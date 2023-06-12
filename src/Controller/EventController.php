<?php

namespace App\Controller;

use App\Services\EventService;
use App\Validation\EventFilterValidation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractController
{
    public function __construct(private EventService $eventService)
    {
        
    }


    public function index(Request $request, EventFilterValidation $eventFilterValidation): JsonResponse
    {
        $eventFilterValidation->validate($request);

        $term = $request->query->get('term');
        $date = $request->query->get('date');
        $page = $request->query->get('page') ?? 1;
        $perPage = $request->query->get('perPage') ?? 10;

        $events = $this->eventService->searchByTermAndDate($term, $date, $page, $perPage);

        return $this->json($events, 200);
    }
}
