<?php

namespace App\Repository;

use App\Entity\Deck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Deck>
 */
class DeckRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deck::class);
    }

    /**
     * @return Deck[]
     */
    public function findAllByLocale(string $locale): array
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.translations', 't', 'WITH', 't.locale = :locale')
            ->addSelect('t')
            ->andWhere('d.show = true')
            ->setParameter('locale', $locale)
            ->orderBy('d.orderInList', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
