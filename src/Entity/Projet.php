<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
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
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $debutAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finAt = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entreprise $entreprise = null;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Tache::class, orphanRemoval: true)]
    private Collection $taches;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: ProjetStatus::class, orphanRemoval: true)]
    private Collection $projetStatuses;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->taches = new ArrayCollection();
        $this->projetStatuses = new ArrayCollection();
    
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

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * @return Collection<int, Tache>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): static
    {
        if (!$this->taches->contains($tach)) {
            $this->taches->add($tach);
            $tach->setProjet($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): static
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getProjet() === $this) {
                $tach->setProjet(null);
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
            $projetStatus->setProjet($this);
        }

        return $this;
    }

    public function removeProjetStatus(ProjetStatus $projetStatus): self
    {
        if ($this->projetStatuses->removeElement($projetStatus)) {
            // set the owning side to null (unless already changed)
            if ($projetStatus->getProjet() === $this) {
                $projetStatus->setProjet(null);
            }
        }

        return $this;
    }

    public function tempsrestant(): ?\DateInterval
    {
        $statusEnCours = null;

        // Recherche du statut "en cours" dans la collection de TacheStatus
        foreach ($this->getProjetStatuses() as $tacheStatus) {
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