<?php

namespace App\Entity;

use App\Repository\AvailabilityRepository;
use App\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AvailabilityRepository::class)]
class Availability
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $idA;

    #[ORM\ManyToOne(targetEntity: Vehicle::class, inversedBy: 'availabilities')]
    #[ORM\JoinColumn(name: "idVehicle", referencedColumnName: "idV", onDelete:'CASCADE')]
    private ?Vehicle $idVehicle;

    #[ORM\Column(type: "datetime_immutable")]
    #[Assert\NotNull()]
    private \DateTimeImmutable $startDateA;

    #[ORM\Column(type: "datetime_immutable")]
    #[Assert\NotNull()]
    #[Assert\GreaterThanOrEqual(propertyPath:'startDateA')]
    private \DateTimeImmutable $endDateA;

    #[ORM\Column(type: "float")]
    #[Assert\NotBlank()]
    #[Assert\Positive()]
    private float $dayPriceA;

    #[ORM\Column(type: "boolean")]
    private bool $statusA;

    public function getIdA(): ?int
    {
        return $this->idA;
    }

    public function getIdVehicle(): ?Vehicle
    {
        return $this->idVehicle;
    }

    public function setIdVehicle(?Vehicle $idVehicle): static
    {
        $this->idVehicle = $idVehicle;

        return $this;
    }

    public function getStartDateA(): ?\DateTimeImmutable
    {
        return $this->startDateA;
    }

    public function setStartDateA(\DateTimeImmutable $startDateA): static
    {
        $this->startDateA = $startDateA;

        return $this;
    }

    public function getEndDateA(): ?\DateTimeImmutable
    {
        return $this->endDateA;
    }

    public function setEndDateA(\DateTimeImmutable $endDateA): static
    {
        $this->endDateA = $endDateA;

        return $this;
    }

    public function getDayPriceA(): ?float
    {
        return $this->dayPriceA;
    }

    public function setDayPriceA(float $dayPriceA): static
    {
        $this->dayPriceA = $dayPriceA;

        return $this;
    }

    public function isStatusA(): bool
    {
        return $this->statusA;
    }

    public function setStatusA(bool $statusA): static
    {
        $this->statusA = $statusA;

        return $this;
    }

    public function getVehicleId(): ?int
    {
        return $this->idVehicle?->getIdV();
    }
}
