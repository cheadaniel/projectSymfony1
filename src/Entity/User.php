<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(inversedBy: 'User', cascade: ['persist', 'remove'])]
    private ?Bank $Bank = null;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Address::class)]
    private Collection $Address;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Acquisition::class)]
    private Collection $Acquisition;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Annonce::class)]
    private Collection $Annonce;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Commentary::class)]
    private Collection $Commentary;

    #[ORM\Column(length: 255)]
    private ?string $Pseudo = null;

    public function __construct()
    {
        $this->Address = new ArrayCollection();
        $this->Acquisition = new ArrayCollection();
        $this->Annonce = new ArrayCollection();
        $this->Commentary = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getBank(): ?Bank
    {
        return $this->Bank;
    }

    public function setBank(?Bank $Bank): self
    {
        $this->Bank = $Bank;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddress(): Collection
    {
        return $this->Address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->Address->contains($address)) {
            $this->Address->add($address);
            $address->setUser($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->Address->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

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
            $acquisition->setUser($this);
        }

        return $this;
    }

    public function removeAcquisition(Acquisition $acquisition): self
    {
        if ($this->Acquisition->removeElement($acquisition)) {
            // set the owning side to null (unless already changed)
            if ($acquisition->getUser() === $this) {
                $acquisition->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonce(): Collection
    {
        return $this->Annonce;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->Annonce->contains($annonce)) {
            $this->Annonce->add($annonce);
            $annonce->setUser($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->Annonce->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getUser() === $this) {
                $annonce->setUser(null);
            }
        }

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
            $commentary->setUser($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): self
    {
        if ($this->Commentary->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getUser() === $this) {
                $commentary->setUser(null);
            }
        }

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->Pseudo;
    }

    public function setPseudo(string $Pseudo): self
    {
        $this->Pseudo = $Pseudo;

        return $this;
    }
}
