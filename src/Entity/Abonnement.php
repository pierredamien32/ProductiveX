<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
class Abonnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'abonnements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entreprise $entreprise_id = null;

    #[ORM\ManyToOne(inversedBy: 'abonnements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formule $formule_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $debutAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $finAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFormuleId(): ?Formule
    {
        return $this->formule_id;
    }

    public function setFormuleId(?Formule $formule_id): self
    {
        $this->formule_id = $formule_id;

        return $this;
    }

    public function getDebutAt(): ?\DateTimeImmutable
    {
        return $this->debutAt;
    }

    public function setDebutAt(\DateTimeImmutable $debutAt): self
    {
        $this->debutAt = $debutAt;

        return $this;
    }

    public function getFinAt(): ?\DateTimeImmutable
    {
        return $this->finAt;
    }

    public function setFinAt(\DateTimeImmutable $finAt): self
    {
        $this->finAt = $finAt;

        return $this;
    }
}
