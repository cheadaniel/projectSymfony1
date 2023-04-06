<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $Price = null;

    #[ORM\Column]
    private ?bool $Is_visible = null;

    #[ORM\ManyToOne(inversedBy: 'Annonce')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\OneToOne(inversedBy: 'Annonce', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Acquisition $Acquisition = null;

    #[ORM\OneToMany(mappedBy: 'Annonce', targetEntity: Commentary::class)]
    private Collection $Commentary;

    public function __construct()
    {
        $this->Commentary = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->Price;
    }

    public function setPrice(string $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function isIsVisible(): ?bool
    {
        return $this->Is_visible;
    }

    public function setIsVisible(bool $Is_visible): self
    {
        $this->Is_visible = $Is_visible;

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

    public function getAcquisition(): ?Acquisition
    {
        return $this->Acquisition;
    }

    public function setAcquisition(Acquisition $Acquisition): self
    {
        $this->Acquisition = $Acquisition;

        return $this;
    }

    /**
     * @return Collection<int, Commentary>
     */
    public function getCommentary(): Collection
    {
        return $this->Commentary;
    }

    public function addCommentary(Commentary $commentary): self
    {
        if (!$this->Commentary->contains($commentary)) {
            $this->Commentary->add($commentary);
            $commentary->setAnnonce($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): self
    {
        if ($this->Commentary->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getAnnonce() === $this) {
                $commentary->setAnnonce(null);
            }
        }

        return $this;
    }
}
