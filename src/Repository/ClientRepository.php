<?php

namespace App\Repository;

use App\Entity\Client;
use App\Utils\NumberUtils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private NumberUtils $numberUtils)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * 
     * @param string|null $city 
     * @param int|null $children 
     * @param string|null $age 
     * @param null|int|string $expenses 
     * @param null|int|string $items 
     * @return Client[] 
     */
    public function findByFilter(
        string $city = null,
        int $children = null,
        string $age = null,
        int | string $expenses = null,
        int | string $items = null
    ): array {
        $cb = $this->createQueryBuilder('c');

        if (!empty($city)) {
            $cb->andWhere('c.city = :city')->setParameter('city', $city);
        }

        if (!empty($children)) {
            $cb->andWhere('c.children = :children')->setParameter('children', $children);
        }

        if (!empty($age)) {
            switch ($age) {
                case 'fibonacci':
                    $fibonacciNumbers = $this->numberUtils->fibonacci(15);
                    $cb
                        ->andWhere('c.age IN (:fibonacciNumbers)')
                        ->setParameter('fibonacciNumbers', $fibonacciNumbers);
                    break;
                case 'min':
                    $cb
                        ->addOrderBy('c.age', 'ASC')
                        ->setMaxResults(3);
                    break;
                case 'max':
                    $cb
                        ->addOrderBy('c.age', 'DESC')
                        ->setMaxResults(3);
                    break;
            }
        }

        if (!empty($expenses) || !empty($items)) {
            $cb->join('c.purchases', 'p');
        }

        if (!empty($expenses)) {
            if (is_numeric($expenses)) {
                $cb
                    ->groupBy('c.id')
                    ->andHaving('SUM(p.price) = :expenses')
                    ->setParameter('expenses', $expenses);
            } else {
                switch ($expenses) {
                    case 'min':
                        $cb
                            ->groupBy('c.id')
                            ->addOrderBy('SUM(p.price)', 'ASC')
                            ->setMaxResults(3);
                        break;
                    case 'max':
                        $cb
                            ->groupBy('c.id')
                            ->addOrderBy('SUM(p.price)', 'DESC')
                            ->setMaxResults(3);
                        break;
                }
            }
        }

        if (!empty($items)) {
            if (is_numeric($items)) {
                $cb
                    ->groupBy('c.id')
                    ->andHaving('SUM(p.quantity) = :items')
                    ->setParameter('items', $items);
            } else {
                switch ($items) {
                    case 'min':
                        $cb
                            ->groupBy('c.id')
                            ->addOrderBy('SUM(p.quantity)', 'ASC')
                            ->setMaxResults(3);
                        break;
                    case 'max':
                        $cb
                            ->groupBy('c.id')
                            ->addOrderBy('SUM(p.quantity)', 'DESC')
                            ->setMaxResults(3);
                        break;
                }
            }
        }

        return $cb
            ->getQuery()
            ->getResult();
    }

    /**
     * 
     * @param string|null $spender 
     * @param string|null $clients 
     * @param string|null $age 
     * @param string|null $children 
     * @return Client[]
     */
    public function findCitiesByFilter(
        string $spender = null,
        string $clients = null,
        string $age = null,
        string $children = null
    ): array {
        $cb = $this->createQueryBuilder('c')
            ->select('DISTINCT c.city')
            ->setMaxResults(3);

        if (!empty($spender) || !empty($clients)) {
            $cb->groupBy('c.city');
        }

        if (!empty($spender)) {
            switch ($spender) {
                case 'min':
                    $cb
                        ->join('c.purchases', 'p')
                        ->addOrderBy('SUM(p.price)', 'ASC');
                    break;
                case 'max':
                    $cb
                        ->join('c.purchases', 'p')
                        ->addOrderBy('SUM(p.price)', 'DESC');
                    break;
            }
        }

        if (!empty($clients)) {
            switch ($clients) {
                case 'min':
                    $cb
                        ->addOrderBy('COUNT(c.city)', 'ASC');
                    break;
                case 'max':
                    $cb
                        ->addOrderBy('COUNT(c.city)', 'DESC');
                    break;
            }
        }

        if (!empty($age)) {
            switch ($age) {
                case 'min':
                    $cb
                        ->addOrderBy('c.age', 'ASC');
                    break;
                case 'max':
                    $cb
                        ->addOrderBy('c.age', 'DESC');
                    break;
            }
        }

        if (!empty($children)) {
            switch ($children) {
                case 'min':
                    $cb
                        ->addOrderBy('c.children', 'ASC');
                    break;
                case 'max':
                    $cb
                        ->addOrderBy('c.children', 'DESC');
                    break;
            }
        }

        var_dump($cb->getQuery()->getSQL());

        return $cb
            ->getQuery()
            ->getResult(Query::HYDRATE_SCALAR_COLUMN);
    }

    //    /**
    //     * @return Client[] Returns an array of Client objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Client
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
