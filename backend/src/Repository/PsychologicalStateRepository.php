<?php

namespace App\Repository;

use App\Entity\PsychologicalState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PsychologicalState>
 */
class PsychologicalStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PsychologicalState::class);
    }

    /**
     * @return PsychologicalState[]
     */
    public function findAllByLocale(string $locale): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.translations', 't', 'WITH', 't.locale = :locale')
            ->addSelect('t')
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getResult();
    }

    public function clearAll(): int
    {
        return $this->createQueryBuilder('s')
            ->delete(PsychologicalState::class, 's')
            ->getQuery()
            ->execute();
    }
}
