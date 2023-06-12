<?php

namespace App\Tests\Unit;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EventRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $eventJsonData;
    

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->eventJsonData = $kernel->getProjectDir(). '/data.json';
    }


    public function testFindByTermAndDate(): void
    {
        $events = $this->entityManager
            ->getRepository(Event::class)
            ->findByTermAndDate('greece', '2024-04-25');
        $this->assertIsArray($events);
    }

    public function testSaveBatch()
    {
        $data = [[
              "name"=> "Ex exercitation et occaecat excepteur nostrud aute voluptate elit.",
              "city"=> "Dupuyer",
              "country"=> "Bahamas",
              "startDate"=> "2024-04-07",
              "endDate"=> "2024-05-11"
        ]];

        $eventsData = array_map(function ($item) {
            $event = new Event();
            $event->setName($item['name'])
                ->setCity($item['city'])
                ->setCountry($item['country'])
                ->setStartDate(new \DateTime($item['startDate']))
                ->setEndDate(new \DateTime($item['endDate']));
            return $event;
        }, $data);

        $events = $this->entityManager
            ->getRepository(Event::class)
            ->saveBatch($eventsData);
        $this->assertTrue($events);
    }

}

