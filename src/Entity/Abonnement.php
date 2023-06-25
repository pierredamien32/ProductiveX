<?php

namespace App\Entity;

use App\Entity\TypeAbonnement;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AbonnementRepository;

#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
class Abonnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $finAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $debutAt = null;

    #[ORM\ManyToOne(inversedBy: 'abonnements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entreprise $entreprise = null;

    #[ORM\ManyToOne(inversedBy: 'abonnements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeAbonnement $typeabonnement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFinAt(): ?\DateTimeImmutable
    {
        return $this->finAt;
    }

    public function setFinAt(\DateTimeImmutable $finAt): static
    {
        $this->finAt = $finAt;

        return $this;
    }

    public function getDebutAt(): ?\DateTimeImmutable
    {
        return $this->debutAt;
    }

    public function setDebutAt(\DateTimeImmutable $debutAt): static
    {
        $this->debutAt = $debutAt;

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

    public function getTypeabonnement(): ?TypeAbonnement
    {
        return $this->typeabonnement;
    }

    public function setTypeabonnement(?TypeAbonnement $typeabonnement): static
    {
        $this->typeabonnement = $typeabonnement;

        return $this;
    }
}