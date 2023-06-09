<?php

namespace App\Tests\Unit;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class EventRepositoryTest extends TestCase
{
    private $entityManager;
    private $registry;
    private $repository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->registry = $this->createMock(ManagerRegistry::class);

        $this->repository = new EventRepository($this->registry);
        $this->repository->setEntityManager($this->entityManager);
    }

    public function testFindByTermAndDate(): void
    {
        // Create a mock query builder
        $queryBuilder = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        // Create a mock query
        $query = $this->getMockBuilder('Doctrine\ORM\AbstractQuery')
            ->disableOriginalConstructor()
            ->getMock();

        // Set up the mock query builder and query
        $this->entityManager->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($queryBuilder);

        $queryBuilder->expects($this->once())
            ->method('select')
            ->willReturnSelf();

        $queryBuilder->expects($this->once())
            ->method('from')
            ->willReturnSelf();

        $queryBuilder->expects($this->exactly(2))
            ->method('andWhere')
            ->willReturnSelf();

        $queryBuilder->expects($this->exactly(2))
            ->method('setParameter')
            ->willReturnSelf();

        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);

        $query->expects($this->once())
            ->method('getResult')
            ->willReturn([]);

        // Call the method to test
        $result = $this->repository->findByTermAndDate('foo', '2022-01-01');

        $this->assertEquals([], $result);
    }
}
