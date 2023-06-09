<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findByTermAndDate(string $term = null, string $date = null): array
    {
        
        $queryBuilder = $this->createQueryBuilder('e');

        // Filter by term: Look for any similar matches on the city or country fields
        if (!empty($term)) {
            $queryBuilder
            ->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->like('LOWER(e.city)', 'LOWER(:term)'),
                    $queryBuilder->expr()->like('LOWER(e.country)', 'LOWER(:term)')
                )
            )
            ->setParameter('term', '%' . str_replace('*', '%', strtolower($term)) . '%');
        }

        // Filter by date: Events that the date searched for is within the range between startDate and endDate
        if (!empty($date)) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->lte(':date', 'e.endDate'),
                    $queryBuilder->expr()->gte(':date', 'e.startDate')
                )
            )->setParameter('date', $date);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function saveBatch(array $events): void
    {
        foreach ($events as $event) {
            $this->getEntityManager()->persist($event);
        }
        $this->getEntityManager()->flush();
    }
}
