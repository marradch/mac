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
        return $this->findAllByLocale($locale, true);
    }

    /**
     * @return list<Topic>
     */
    public function findAllByLocale(string $locale, bool $homepage = false): array
    {
        $qb = $this->createQueryBuilder('topic')
            ->leftJoin('topic.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->addSelect('translation')
            ->setParameter('locale', $locale)
            ->andWhere('topic.show = true')
            ->orderBy('topic.homepageOrder', 'ASC')
            ->addOrderBy('topic.id', 'ASC');

        if ($homepage) {
            $qb->andWhere('topic.showOnHomepage = true');
        }

        return $qb->getQuery()->getResult();
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
            ->andWhere('topic.show = true')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
