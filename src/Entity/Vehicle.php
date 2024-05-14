<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Availability;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('vehicleNumber')]
#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idV', type: 'integer')]
    private ?int $idV;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank()]
    private string $brand;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank()]
    private string $model;


    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 7, max: 7)]
    private string $vehicleNumber;

    /**
     * @var Collection<int, Availability>
     */

    #[ORM\OneToMany(targetEntity: Availability::class, mappedBy: 'idVehicle')]
    private Collection $availabilities;

    public function getIdV(): ?int
    {
        return $this->idV;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->availabilities = new ArrayCollection();
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getVehicleNumber(): ?string
    {
        return $this->vehicleNumber;
    }

    public function setVehicleNumber(string $vehicleNumber): self
    {
        $this->vehicleNumber = $vehicleNumber;
        return $this;
    }

    /**
     * @return Collection<int, Availability>
     */
    public function getAvailability(): Collection
    {
        return $this->availabilities;
    }

    public function addAvailability(Availability $availabilities): self
    {
        if (!$this->availabilities->contains($availabilities)) {
            $this->availabilities->add($availabilities);
            $availabilities->setIdVehicle($this);
        }

        return $this;
    }

    public function removeAvailability(Availability $availabilities): self
    {
        if ($this->availabilities->removeElement($availabilities)) {
            // set the owning side to null (unless already changed)
            if ($availabilities->getIdVehicle() === $this) {
                $availabilities->setIdVehicle(null);
            }
        }

        return $this;
    }
}
