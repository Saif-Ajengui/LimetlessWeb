<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class formationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }


    // /**
    //  * @return Formation[] Returns an array of Formation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Formation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function OrderByidQB(){
        return $this->createQueryBuilder('f')
            ->getQuery()->getResult();
    }
    public function OrderByidform($idf){
        return $this->createQueryBuilder('f')

            ->where('f.id=:idf')
            ->setParameter('idf',$idf)
            ->getQuery()->getResult();
    }
//Sta3milthe fi tri
    public function OrderById(){
        $em=$this->getEntityManager();
        $query=$em->createQuery(
            'select f from App\Entity\Formation f ORDER BY f.id desc'
            //'select f from App\Entity\Formation f where f.id= (select p.idformation from App\Entity\Participants p where p.idclient=3)'
        );
        return $query->getResult();
    }
    public function mesformations($id){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select f from App\Entity\Formation f where f.id IN 
        (SELECT IDENTITY(p.idformation) from App\Entity\Participants p where p.idclient=:id )ORDER BY f.date asc')
            ->setParameter('id',$id);
        return $query->getResult();
    }

}
