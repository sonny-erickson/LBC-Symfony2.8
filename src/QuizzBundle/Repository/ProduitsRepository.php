<?php

namespace QuizzBundle\Repository;

/**
 * ProduitsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitsRepository extends \Doctrine\ORM\EntityRepository
{

    public function getLastProducts()
    {
        return $this->createQueryBuilder('p')
            ->addOrderBy('p.date', 'DESC')
            ->getQuery()
            ->execute();
    }




    public function findByCategory($categoryId, $search) {
        return $this->findBy(['categories' => $categoryId]);
    }
}
