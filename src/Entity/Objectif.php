<?php

namespace App\Entity;

use App\Repository\ObjectifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjectifRepository::class)]
class Objectif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $objectif = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'objectifs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    #[ORM\OneToMany(mappedBy: 'objectif', targetEntity: SuiviJournalier::class, orphanRemoval: true)]
    private Collection $suiviJournaliers;

    public function __construct()
    {
        $this->suiviJournaliers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectif(): ?string
    {
        return $this->objectif;
    }

    public function setObjectif(string $objectif): self
    {
        $this->objectif = $objectif;

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

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

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
            $suiviJournalier->setObjectif($this);
        }

        return $this;
    }

    public function removeSuiviJournalier(SuiviJournalier $suiviJournalier): self
    {
        if ($this->suiviJournaliers->removeElement($suiviJournalier)) {
            // set the owning se to null (unless already changed)
            if ($suiviJournalier->getObjectif() === $this) {
                $suiviJournalier->setObjectif(null);
            }
        }

        return $this;
    }
}