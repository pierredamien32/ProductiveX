<?php

namespace App\Entity;

use App\Repository\ReponseEmployeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseEmployeRepository::class)]
class ReponseEmploye
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $conseil = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isConseil(): ?bool
    {
        return $this->conseil;
    }

    public function setConseil(bool $conseil): static
    {
        $this->conseil = $conseil;

        return $this;
    }
}
