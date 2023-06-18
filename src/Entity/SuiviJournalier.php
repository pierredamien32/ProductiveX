<?php

namespace App\Entity;

use App\Repository\SuiviJournalierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuiviJournalierRepository::class)]
class SuiviJournalier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'suiviJournaliers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Objectif $objectif = null;

    #[ORM\ManyToOne(inversedBy: 'suiviJournaliers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Rappel $rappel = null;

    #[ORM\ManyToOne(inversedBy: 'suiviJournaliers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectif(): ?Objectif
    {
        return $this->objectif;
    }

    public function setObjectif(?Objectif $objectif): self
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function getRappel(): ?Rappel
    {
        return $this->rappel;
    }

    public function setRappel(?Rappel $rappel): self
    {
        $this->rappel = $rappel;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}