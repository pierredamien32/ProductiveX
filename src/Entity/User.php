<?php

namespace App\Entity;

use App\Entity\Rappel;
use App\Entity\Employe;
use App\Entity\Entreprise;
use App\Entity\Commentaire;
use App\Entity\Notification;
use App\Entity\SuiviJournalier;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
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

    private ?string $plainPassword = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numtel = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Entreprise $entreprise = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Employe $employe = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Notification::class, orphanRemoval: true)]
    private Collection $notifications;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Rappel::class, orphanRemoval: true)]
    private Collection $rappels;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: SuiviJournalier::class, orphanRemoval: true)]
    private Collection $suiviJournaliers;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->commentaires = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->rappels = new ArrayCollection();
        $this->suiviJournaliers = new ArrayCollection();
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
     * Get the value of plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(?string $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(Entreprise $entreprise): self
    {
        // set the owning side of the relation if necessary
        if ($entreprise->getUser() !== $this) {
            $entreprise->setUser($this);
        }

        $this->entreprise = $entreprise;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(Employe $employe): self
    {
        // set the owning side of the relation if necessary
        if ($employe->getUser() !== $this) {
            $employe->setUser($this);
        }

        $this->employe = $employe;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning se to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rappel>
     */
    public function getRappels(): Collection
    {
        return $this->rappels;
    }

    public function addRappel(Rappel $rappel): self
    {
        if (!$this->rappels->contains($rappel)) {
            $this->rappels->add($rappel);
            $rappel->setUser($this);
        }

        return $this;
    }

    public function removeRappel(Rappel $rappel): self
    {
        if ($this->rappels->removeElement($rappel)) {
            // set the owning se to null (unless already changed)
            if ($rappel->getUser() === $this) {
                $rappel->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SuiviJournalier>
     */
    public function getSuiviJournaliers(): Collection
    {
        return $this->suiviJournaliers;
    }

    public function addSuiviJournalier(SuiviJournalier $suiviJournalier): self
    {
        if (!$this->suiviJournaliers->contains($suiviJournalier)) {
            $this->suiviJournaliers->add($suiviJournalier);
            $suiviJournalier->setUser($this);
        }

        return $this;
    }

    public function removeSuiviJournalier(SuiviJournalier $suiviJournalier): self
    {
        if ($this->suiviJournaliers->removeElement($suiviJournalier)) {
            // set the owning se to null (unless already changed)
            if ($suiviJournalier->getUser() === $this) {
                $suiviJournalier->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
   
}