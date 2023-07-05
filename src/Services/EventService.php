<?php

namespace App\Services;

use App\Entity\Event;
use App\Interfaces\EventInterface;
use App\Repository\EventRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class EventService implements EventInterface{
    public function __construct(
        private EventRepository $eventRepository,
        private CacheInterface $cache,
        private LoggerInterface $logger,
        private KernelInterface $kernel)
        {
            
        }

    public function searchByTermAndDate(string $term = null, string $date = null, int $page
    , int $perPage): array{

        $this->logger->info('Event filter request', [
            'term' => $term,
            'date' => $date,
            'page' => $page,
            'perPage' => $perPage,
        ]);

        $cacheKey = 'events__'.$term.$date.$page.$perPage;

        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($term, $date, $page,
         $perPage) {
             
            $item->expiresAfter(36000); 
            $events = $this->eventRepository->findByTermAndDate($term, $date);

            $totalEvents = count($events);
            $totalPages = ceil($totalEvents / $perPage);
            $offset = ($page - 1) * $perPage;
            $paginatedEvents = array_slice($events, $offset, $perPage);

            
            $item->expiresAfter(3600);

            return [
                'data' => $paginatedEvents,
                'page' => $page,
                'perPage' => $perPage,
                'totalPage' => $totalPages
            ];
        });
    }

    public function importEventToDatabase():string{
        $jsonData = file_get_contents($this->kernel->getProjectDir() . '/data.json');
        $data = json_decode($jsonData, true);

        $events = array_map(function ($item) {
            $event = new Event();
            $event->setName($item['name'])
                ->setCity($item['city'])
                ->setCountry($item['country'])
                ->setStartDate(new \DateTime($item['startDate']))
                ->setEndDate(new \DateTime($item['endDate']));
        
            return $event;
        }, $data);

        $this->eventRepository->saveBatch($events);
        // $this->cache->deleteItem('events__');
        return "Events saved successfully";
    }
}