<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: Notification::class, orphanRemoval: true)]
    private Collection $notifications;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: ProjetStatus::class, orphanRemoval: true)]
    private Collection $projetStatuses;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: TacheStatus::class, orphanRemoval: true)]
    private Collection $tacheStatuses;


    public function __construct()
    {
        $this->notifications = new ArrayCollection();
        $this->projetStatuses = new ArrayCollection();
        $this->tacheStatuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setStatus($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getStatus() === $this) {
                $notification->setStatus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProjetStatus>
     */
    public function getProjetStatuses(): Collection
    {
        return $this->projetStatuses;
    }

    public function addProjetStatus(ProjetStatus $projetStatus): self
    {
        if (!$this->projetStatuses->contains($projetStatus)) {
            $this->projetStatuses->add($projetStatus);
            $projetStatus->setStatus($this);
        }

        return $this;
    }

    public function removeProjetStatus(ProjetStatus $projetStatus): self
    {
        if ($this->projetStatuses->removeElement($projetStatus)) {
            // set the owning side to null (unless already changed)
            if ($projetStatus->getStatus() === $this) {
                $projetStatus->setStatus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TacheStatus>
     */
    public function getTacheStatuses(): Collection
    {
        return $this->tacheStatuses;
    }

    public function addTacheStatus(TacheStatus $tacheStatus): self
    {
        if (!$this->tacheStatuses->contains($tacheStatus)) {
            $this->tacheStatuses->add($tacheStatus);
            $tacheStatus->setStatus($this);
        }

        return $this;
    }

    public function removeTacheStatus(TacheStatus $tacheStatus): self
    {
        if ($this->tacheStatuses->removeElement($tacheStatus)) {
            // set the owning side to null (unless already changed)
            if ($tacheStatus->getStatus() === $this) {
                $tacheStatus->setStatus(null);
            }
        }

        return $this;
    }

}