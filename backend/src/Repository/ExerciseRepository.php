<?php

namespace App\Repository;

use App\Entity\Exercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercise>
 */
class ExerciseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercise::class);
    }

    /**
     * @return Exercise[]
     */
    public function findAllByLocale(string $locale): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.translations', 't', 'WITH', 't.locale = :locale')
            ->addSelect('t')
            ->andWhere('e.show = true')
            ->setParameter('locale', $locale)
            ->orderBy('e.orderInList', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneBySlugAndLocale(string $locale, string $slug): ?Exercise
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.translations', 't', 'WITH', 't.locale = :locale')
            ->addSelect('t')
            ->andWhere('e.slug = :slug')
            ->andWhere('e.show = true')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

