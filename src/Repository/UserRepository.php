<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return array
     */
    public function findAllPaginate(array $queries = [])
    {
        $qb = $this->createQueryBuilder('u');
        if (!array_key_exists('page', $queries)) {
            $queries['page'] = 1;
        }
        if (!array_key_exists('par_page', $queries)) {
            $queries['par_page'] = 10;
        }

        if (array_key_exists('q', $queries)) {
            if ($id = intval($queries['q'])) {
                $qb->orWhere('u.id = :id')
                    ->setParameter('id', $id);
            }
            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('u.nom', ':q'),
                $qb->expr()->like('u.prenom', ':q'),
                $qb->expr()->like('u.email', ':q')
            ))
                ->setParameter('q', '%'. $queries['q'] .'%');
        }

        $qbCount = clone $qb;
        $qbCount->select('count(u.id)');

        $qb->setFirstResult(($queries['page'] - 1) * $queries['par_page'])
            ->setMaxResults($queries['par_page'])
            ->addOrderBy('u.id', 'DESC');
        return ['content' => $qb->getQuery()->getResult(), 'total' => $qbCount->getQuery()->getSingleScalarResult()];
    }
}
