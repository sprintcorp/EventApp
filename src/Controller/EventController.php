<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

#[Route('/api/event', name: 'api')]
class EventController extends AbstractController
{
    public function __construct(private EventRepository $eventRepository,
     private CacheInterface $cache, private LoggerInterface $logger)
    {
        
    }

    #[Route('/', name: 'app_event', methods: 'GET')]
    public function index(Request $request): JsonResponse
    {
        $term = $request->query->get('term');
        $date = $request->query->get('date');

        $this->logger->info('Event search request', [
            'term' => $term,
            'date' => $date,
        ]);

        $events = $this->eventRepository->search($term, $date);

        return $this->json($events);
    }
}
