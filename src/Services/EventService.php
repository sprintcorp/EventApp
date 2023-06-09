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
    public function __construct(private EventRepository $eventRepository
    , private CacheInterface $cache, private LoggerInterface $logger, private KernelInterface $kernel)
    {
        
    }

    public function searchByTermAndDate(string $term = null, string $date = null): array{
        $this->logger->info('Event search request', [
            'term' => $term,
            'date' => $date,
        ]);
        return $this->cache->get('events_' . md5($term . $date), function (ItemInterface $item) use ($term, $date) {
            return $this->eventRepository->findByTermAndDate($term, $date);
        });
    }

    public function importEventToDatabase():string{
        $jsonData = file_get_contents($this->kernel->getProjectDir() . '/data.json');
        $data = json_decode($jsonData, true);

        $events = [];
        
        foreach ($data as $item) {
            $event = new Event();
            $event->setName($item['name']);
            $event->setCity($item['city']);
            $event->setCountry($item['country']);
            $event->setStartDate(new \DateTime($item['startDate']));
            $event->setEndDate(new \DateTime($item['endDate']));

            $events[] = $event;
        }

        $this->eventRepository->saveBatch($events);
        return "Events saved successfully";
    }
}