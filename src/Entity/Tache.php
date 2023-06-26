<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TacheRepository::class)]
class Tache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?\DateInterval $duree = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $debutAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finAt = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projet $projet = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employe $employe = null;

    #[ORM\OneToMany(mappedBy: 'tache', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'tache', targetEntity: TacheStatus::class, orphanRemoval: true)]
    private Collection $tacheStatuses;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->commentaires = new ArrayCollection();
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

    public function getDuree(): ?\DateInterval
    {
        return $this->duree;
    }

    public function setDuree(\DateInterval $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDebutAt(): ?\DateTimeInterface
    {
        return $this->debutAt;
    }

    public function setDebutAt(?\DateTimeInterface $debutAt): static
    {
        $this->debutAt = $debutAt;

        return $this;
    }

    public function getFinAt(): ?\DateTimeInterface
    {
        return $this->finAt;
    }

    public function setFinAt(?\DateTimeInterface $finAt): static
    {
        $this->finAt = $finAt;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): static
    {
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

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setTache($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getTache() === $this) {
                $commentaire->setTache(null);
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
            $tacheStatus->setTache($this);
        }

        return $this;
    }

    public function removeTacheStatus(TacheStatus $tacheStatus): self
    {
        if ($this->tacheStatuses->removeElement($tacheStatus)) {
            // set the owning side to null (unless already changed)
            if ($tacheStatus->getTache() === $this) {
                $tacheStatus->setTache(null);
            }
        }

        return $this;
    }

    public function tempsrestant(): ?\DateInterval
    {
        $statusEnCours = null;

        // Recherche du statut "en cours" dans la collection de TacheStatus
        foreach ($this->getTacheStatuses() as $tacheStatus) {
            if ($tacheStatus->getStatus() && $tacheStatus->getStatus()->getNom() === 'En cours') {
                $statusEnCours = $tacheStatus;
                break;
            }
        }

        if ($statusEnCours) {
            $now = new \DateTime();
            $datefuture = $statusEnCours->getCreatedAt()->add($this->getDuree());
            $timerestant = $datefuture->diff($now);

            return $timerestant;
        }

        return null; // Si aucun statut "en cours" n'est trouvé
    }

   
}