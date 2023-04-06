<?php

namespace App\Entity;

use App\Repository\BankRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BankRepository::class)]
class Bank
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $Amount = null;

    #[ORM\OneToOne(mappedBy: 'Bank', cascade: ['persist', 'remove'])]
    private ?User $User = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(?int $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        // unset the owning side of the relation if necessary
        if ($User === null && $this->User !== null) {
            $this->User->setBank(null);
        }

        // set the owning side of the relation if necessary
        if ($User !== null && $User->getBank() !== $this) {
            $User->setBank($this);
        }

        $this->User = $User;

        return $this;
    }
}
