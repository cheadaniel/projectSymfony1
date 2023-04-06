<?php

namespace App\Entity;

use App\Repository\AcquisitionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcquisitionRepository::class)]
class Acquisition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Acquisition')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $Address = null;

    #[ORM\ManyToOne(inversedBy: 'Acquisition')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\OneToOne(mappedBy: 'Acquisition', cascade: ['persist', 'remove'])]
    private ?Annonce $Annonce = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(?Address $Address): self
    {
        $this->Address = $Address;

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

    public function getAnnonce(): ?Annonce
    {
        return $this->Annonce;
    }

    public function setAnnonce(Annonce $Annonce): self
    {
        // set the owning side of the relation if necessary
        if ($Annonce->getAcquisition() !== $this) {
            $Annonce->setAcquisition($this);
        }

        $this->Annonce = $Annonce;

        return $this;
    }
}
