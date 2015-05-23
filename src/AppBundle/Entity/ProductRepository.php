<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function getProductsQuery()
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('p, c')
            ->from('AppBundle:Product', 'p')            
            ->leftJoin('p.category', 'c')
            ->orderBy('p.name', 'DESC')
            ->getQuery()
        ;
    }

    public function getProducts()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('p, c')
            ->from('AppBundle:Product', 'p')
            ->leftJoin('p.category', 'c')
            ->orderBy('p.name', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function getProduct($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('p, c')
            ->from('AppBundle:Product', 'p')
            ->leftJoin('p.category', 'c')
            ->where('p.id=:id')
            ->setParameter('id', $id, \PDO::PARAM_INT)
            ->orderBy('p.name', 'DESC')
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findProducts($keyword)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb
            ->select('p, c')
            ->from('AppBundle:Product', 'p')
            ->leftJoin('p.category', 'c')
            ->where('p.name LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->orderBy('p.name', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function findProductsQuery($keyword)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb
            ->select('p, c')
            ->from('AppBundle:Product', 'p')
            ->leftJoin('p.category', 'c')
            ->where('p.name LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->orderBy('p.name', 'ASC')
        ;

        return $qb->getQuery();
    }
}