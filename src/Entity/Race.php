<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RaceRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups" = {"read:race"}}
 * )
 */
class Race
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:race"})
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:race"})
     */
    private ?string $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Chien::class, mappedBy="races")
     */
    private Collection $chiens;

    public function __construct()
    {
        $this->chiens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Chien[]
     */
    public function getChiens(): Collection
    {
        return $this->chiens;
    }

    public function addChien(Chien $chien): self
    {
        if (!$this->chiens->contains($chien)) {
            $this->chiens[] = $chien;
            $chien->addRace($this);
        }

        return $this;
    }

    public function removeChien(Chien $chien): self
    {
        if ($this->chiens->removeElement($chien)) {
            $chien->removeRace($this);
        }

        return $this;
    }
}
