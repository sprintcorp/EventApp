<?php

namespace App\Controller;

use App\Services\EventService;
use App\Validation\EventFilterValidation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/event', name: 'api')]
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

        $events = $this->eventService->searchByTermAndDate($term, $date);

        return $this->json([
            'data'=>$events], 200);
    }
}
