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
    private ?Objectif $objectif_id = null;

    #[ORM\ManyToOne(inversedBy: 'suiviJournaliers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Rappel $rappel_id = null;

    #[ORM\ManyToOne(inversedBy: 'suiviJournaliers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectifId(): ?Objectif
    {
        return $this->objectif_id;
    }

    public function setObjectifId(?Objectif $objectif_id): self
    {
        $this->objectif_id = $objectif_id;

        return $this;
    }

    public function getRappelId(): ?Rappel
    {
        return $this->rappel_id;
    }

    public function setRappelId(?Rappel $rappel_id): self
    {
        $this->rappel_id = $rappel_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
