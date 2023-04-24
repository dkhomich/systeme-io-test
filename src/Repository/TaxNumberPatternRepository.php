<?php

namespace App\Repository;

use App\Entity\TaxNumberPattern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaxNumberPattern>
 *
 * @method TaxNumberPattern|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxNumberPattern|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxNumberPattern[]    findAll()
 * @method TaxNumberPattern[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxNumberPatternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxNumberPattern::class);
    }

    public function save(TaxNumberPattern $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TaxNumberPattern $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getMatchedByTaxNumber(string $taxNumber): ?TaxNumberPattern
    {
        foreach ($this->findAll() as $taxNumberPattern) {
            if (preg_match((string)$taxNumberPattern->getPattern(), $taxNumber)) {
                return $taxNumberPattern;
            }
        }
        return null;
    }
}
