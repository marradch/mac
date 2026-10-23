<?php

namespace App\Repository;

use App\Entity\Topic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Topic>
 */
class TopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }

    /**
     * @return list<Topic>
     */
    public function findAllForHomepageByLocale(string $locale): array
    {
        return $this->createQueryBuilder('topic')
            ->leftJoin('topic.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->addSelect('translation')
            ->andWhere('topic.showOnHomepage = true')
            ->setParameter('locale', $locale)
            ->orderBy('topic.homepageOrder', 'ASC')
            ->addOrderBy('topic.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneBySlugAndLocale(string $slug, string $locale): ?Topic
    {
        return $this->createQueryBuilder('topic')
            ->leftJoin('topic.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->addSelect('translation')
            ->leftJoin('topic.questions', 'question')
            ->addSelect('question')
            ->leftJoin('question.translations', 'questionTranslation', 'WITH', 'questionTranslation.locale = :locale')
            ->addSelect('questionTranslation')
            ->andWhere('topic.slug = :slug')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
