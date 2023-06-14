<?php

namespace App\Entity;

use App\Repository\RappelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RappelRepository::class)]
class Rappel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $rappelAt = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu = null;

    #[ORM\ManyToOne(inversedBy: 'rappels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\OneToMany(mappedBy: 'rappel_id', targetEntity: SuiviJournalier::class, orphanRemoval: true)]
    private Collection $suiviJournaliers;

    public function __construct()
    {
        $this->suiviJournaliers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRappelAt(): ?\DateTimeImmutable
    {
        return $this->rappelAt;
    }

    public function setRappelAt(\DateTimeImmutable $rappelAt): self
    {
        $this->rappelAt = $rappelAt;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

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
            $suiviJournalier->setRappelId($this);
        }

        return $this;
    }

    public function removeSuiviJournalier(SuiviJournalier $suiviJournalier): self
    {
        if ($this->suiviJournaliers->removeElement($suiviJournalier)) {
            // set the owning side to null (unless already changed)
            if ($suiviJournalier->getRappelId() === $this) {
                $suiviJournalier->setRappelId(null);
            }
        }

        return $this;
    }
}
