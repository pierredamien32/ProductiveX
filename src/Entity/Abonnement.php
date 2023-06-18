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
    private ?Entreprise $entreprise = null;

    #[ORM\ManyToOne(inversedBy: 'abonnements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formule $formule = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $debutAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $finAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getFormule(): ?Formule
    {
        return $this->formule;
    }

    public function setFormule(?Formule $formule): self
    {
        $this->formule = $formule;

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