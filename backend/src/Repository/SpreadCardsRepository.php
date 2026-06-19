<?php

namespace App\Repository;

use App\Entity\SpreadCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SpreadCards>
 */
class SpreadCardsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpreadCard::class);
    }

    public function findAllByLocaleAndSpread(string $locale, int $spreadId): array
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.spreadCardTranslations', 't', 'WITH', 't.locale = :locale')
            ->addSelect('t')
            ->andWhere('c.spread = :spreadId')
            ->setParameter('locale', $locale)
            ->setParameter('spreadId', $spreadId)
            ->orderBy('c.orderInList', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
