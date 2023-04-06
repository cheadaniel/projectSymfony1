<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Street = null;

    #[ORM\Column(length: 255)]
    private ?string $City = null;

    #[ORM\Column]
    private ?int $Zip = null;

    #[ORM\ManyToOne(inversedBy: 'Address')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\OneToMany(mappedBy: 'Address', targetEntity: Acquisition::class)]
    private Collection $Acquisition;

    public function __construct()
    {
        $this->Acquisition = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->Street;
    }

    public function setStreet(string $Street): self
    {
        $this->Street = $Street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getZip(): ?int
    {
        return $this->Zip;
    }

    public function setZip(int $Zip): self
    {
        $this->Zip = $Zip;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection<int, Acquisition>
     */
    public function getAcquisition(): Collection
    {
        return $this->Acquisition;
    }

    public function addAcquisition(Acquisition $acquisition): self
    {
        if (!$this->Acquisition->contains($acquisition)) {
            $this->Acquisition->add($acquisition);
            $acquisition->setAddress($this);
        }

        return $this;
    }

    public function removeAcquisition(Acquisition $acquisition): self
    {
        if ($this->Acquisition->removeElement($acquisition)) {
            // set the owning side to null (unless already changed)
            if ($acquisition->getAddress() === $this) {
                $acquisition->setAddress(null);
            }
        }

        return $this;
    }
}
