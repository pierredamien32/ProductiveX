<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poste = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $debutcontratAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $fincontratAt = null;

    #[ORM\OneToOne(inversedBy: 'employe', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'employes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entreprise $entreprise_id = null;

    #[ORM\OneToMany(mappedBy: 'employe_id', targetEntity: Tache::class, orphanRemoval: true)]
    private Collection $taches;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(?string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getDebutcontratAt(): ?\DateTimeImmutable
    {
        return $this->debutcontratAt;
    }

    public function setDebutcontratAt(?\DateTimeImmutable $debutcontratAt): self
    {
        $this->debutcontratAt = $debutcontratAt;

        return $this;
    }

    public function getFincontratAt(): ?\DateTimeImmutable
    {
        return $this->fincontratAt;
    }

    public function setFincontratAt(?\DateTimeImmutable $fincontratAt): self
    {
        $this->fincontratAt = $fincontratAt;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getEntrepriseId(): ?Entreprise
    {
        return $this->entreprise_id;
    }

    public function setEntrepriseId(?Entreprise $entreprise_id): self
    {
        $this->entreprise_id = $entreprise_id;

        return $this;
    }

    /**
     * @return Collection<int, Tache>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches->add($tach);
            $tach->setEmployeId($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): self
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getEmployeId() === $this) {
                $tach->setEmployeId(null);
            }
        }

        return $this;
    }
}