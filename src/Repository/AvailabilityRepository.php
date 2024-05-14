<?php

namespace App\Repository;

use App\Entity\Availability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Availability>
 */
class AvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Availability::class);
    }

    public function findVehicle(\DateTime $searchStartDate, \DateTime $searchEndDate, int $maxPrice): array
    {
        $period = $searchStartDate->diff($searchEndDate)->d + 1;

        return $this->createQueryBuilder('a')
            ->andWhere('a.endDateA >= :searchEndDate')
            ->andWhere('a.startDateA <= :searchStartDate')
            ->andWhere('a.dayPriceA * :period <= :maxPrice')
            ->setParameter('searchStartDate', $searchStartDate)
            ->setParameter('searchEndDate', $searchEndDate)
            ->setParameter('period', $period)
            ->setParameter('maxPrice', $maxPrice)
            ->getQuery()->getResult();
    }
    public function findVehicleAdjust(\DateTime $searchStartDate, \DateTime $searchEndDate, int $maxPrice, int $offset = 0): array
    {
        $period = $searchStartDate->diff($searchEndDate)->d + 1;
        $searchStartDateBefore = (clone $searchStartDate)->modify("-{$offset} day");
        $searchStartDateAfter = (clone $searchStartDate)->modify("+{$offset} day");
        $searchEndDateBefore = (clone $searchEndDate)->modify("-{$offset} day");
        $searchEndDateAfter = (clone $searchEndDate)->modify("+{$offset} day");

        return $this->createQueryBuilder('a')
            ->andWhere('a.dayPriceA * :period <= :maxPrice')
            ->andWhere('a.endDateA >= :searchEndDateBefore OR a.endDateA >= :searchEndDateAfter')
            ->andWhere('a.startDateA <= :searchStartDateBefore OR a.startDateA <= :searchStartDateAfter')
            ->setParameter('searchStartDateBefore', $searchStartDateBefore)
            ->setParameter('searchStartDateAfter', $searchStartDateAfter)
            ->setParameter('searchEndDateBefore', $searchEndDateBefore)
            ->setParameter('searchEndDateAfter', $searchEndDateAfter)
            ->setParameter('period', $period)
            ->setParameter('maxPrice', $maxPrice)
            ->getQuery()->getResult();
    }
}
