<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

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
    public function __construct(ManagerRegistry $registry, private CacheInterface $cache)
    {
        parent::__construct($registry, Event::class);
    }

    public function search(string $term = null, string $date = null): array
    {
        return $this->cache->get('events_' . md5($term . $date), function (ItemInterface $item) use ($term, $date) {
            $queryBuilder = $this->createQueryBuilder('e');

            if ($term) {
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->orX(
                        $queryBuilder->expr()->like('e.city', ':term'),
                        $queryBuilder->expr()->like('e.country', ':term')
                    ))
                    ->setParameter('term', '%' . $term . '%');
            }

            if ($date) {
                $queryBuilder
                    ->andWhere('e.startDate <= :date')
                    ->andWhere('e.endDate >= :date')
                    ->setParameter('date', $date);
            }

            return $queryBuilder->getQuery()->getResult();
        });
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
