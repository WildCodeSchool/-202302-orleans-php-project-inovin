<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminDashboardRepository;

#[ORM\Table(name: "view_admin_dashboard")]
#[ORM\Entity(repositoryClass: AdminDashboardRepository::class, readOnly: true)]
class AdminDashboard
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "integer", length: 255)]
    private int $nbrGrapeVarieties;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrGrapeVarieties(): ?int
    {
        return $this->nbrGrapeVarieties;
    }

    public function setNbrGrapeVarieties(int $nbrGrapeVarieties): static
    {
        $this->nbrGrapeVarieties = $nbrGrapeVarieties;

        return $this;
    }
}
