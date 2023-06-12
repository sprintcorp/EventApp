<?php

use PHPUnit\Framework\TestCase;
use App\Services\EventService;
use App\Repository\EventRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class EventServiceTest extends TestCase
{
    private $eventRepository;
    private $cache;
    private $logger;
    private $kernel;
    private $eventService;
    
    protected function setUp(): void
    {
        $this->eventRepository = $this->createMock(EventRepository::class);
        $this->cache = $this->createMock(CacheInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->kernel = $this->createMock(KernelInterface::class);
        
        $this->eventService = new EventService(
            $this->eventRepository,
            $this->cache,
            $this->logger,
            $this->kernel
        );
    }
    
    public function testSearchByTermAndDate()
    {
        $term = 'example';
        $date = '2023-06-12';
        $page = 1;
        $perPage = 10;
        
        $events = [
            [
                'name' => 'Event 1',
                'city' => 'City 1',
                'country' => 'Country 1',
                'startDate' => '2023-06-12',
                'endDate' => '2023-06-15',
            ]
        ];
        
        $expectedResponse = [
            'data' => $events,
            'page' => $page,
            'perPage' => $perPage,
            'totalPage' => 1
        ];
        
        $this->logger->expects($this->once())
            ->method('info')
            ->with('Event search request', [
                'term' => $term,
                'date' => $date,
            ]);
        
        $this->cache->expects($this->once())
            ->method('get')
            ->willReturnCallback(function ($cacheKey, $callback) use ($term, $date, $page, $perPage,
            $events, $expectedResponse) {
                $item = $this->createMock(ItemInterface::class);
                
                
                $this->eventRepository->expects($this->once())
                    ->method('findByTermAndDate')
                    ->with($term, $date)
                    ->willReturn($events);
                
                $result = $callback($item);
                $this->assertEquals($expectedResponse, $result);
                
                return $result;
            });
        
        $response = $this->eventService->searchByTermAndDate($term, $date, $page, $perPage);
        
        $this->assertEquals($expectedResponse, $response);
    }
}
