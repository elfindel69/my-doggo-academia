<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use App\Repository\RaceRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups" = {"read:annonce", "read:chien"}}
 * )
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:annonce"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:annonce"})
     */
    private ?string $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"read:annonce"})
     */
    private ?string $description;

    /**
     * @ORM\OneToMany(targetEntity=Chien::class, mappedBy="annonce", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid()
     * @Groups({"read:annonce"})
     */
    private Collection $chiens;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:annonce"})
     */
    private ?DateTimeInterface $dateCreation;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:annonce"})
     */
    private ?DateTimeInterface $dateMaJ;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"read:annonce"})
     */
    private ?bool $aPourvoir;

    /**
     * @ORM\OneToMany(targetEntity=DemandeAdoption::class, mappedBy="annonce")
     */
    private Collection $demandesAdoption;

    /**
     * @ORM\ManyToOne(targetEntity=Annonceur::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Annonceur $annonceur;

    public function __construct()
    {
        $this->chiens = new ArrayCollection();
        $this->demandesAdoption = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $chien->setAnnonce($this);
        }

        return $this;
    }

    public function removeChien(Chien $chien): self
    {
        if ($this->chiens->removeElement($chien)) {
            // set the owning side to null (unless already changed)
            if ($chien->getAnnonce() === $this) {
                $chien->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getDateCreation(): ?DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateMaJ(): ?DateTimeInterface
    {
        return $this->dateMaJ;
    }

    public function setDateMaJ(DateTimeInterface $dateMaJ): self
    {
        $this->dateMaJ = $dateMaJ;

        return $this;
    }

    public function getAPourvoir(): ?bool
    {
        return $this->aPourvoir;
    }

    public function setAPourvoir(?bool $aPourvoir): self
    {
        $this->aPourvoir = $aPourvoir;

        return $this;
    }


    /**
     * @return Collection|DemandeAdoption[]
     */
    public function getDemandesAdoption(): Collection
    {
        return $this->demandesAdoption;
    }

    public function addDemandesAdoption(DemandeAdoption $demandesAdoption): self
    {
        if (!$this->demandesAdoption->contains($demandesAdoption)) {
            $this->demandesAdoption[] = $demandesAdoption;
            $demandesAdoption->setAnnonce($this);
        }

        return $this;
    }

    public function removeDemandesAdoption(DemandeAdoption $demandesAdoption): self
    {
        if ($this->demandesAdoption->removeElement($demandesAdoption)) {
            // set the owning side to null (unless already changed)
            if ($demandesAdoption->getAnnonce() === $this) {
                $demandesAdoption->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getAnnonceur(): ?Annonceur
    {
        return $this->annonceur;
    }

    public function setAnnonceur(?Annonceur $annonceur): self
    {
        $this->annonceur = $annonceur;

        return $this;
    }

    public function getNbChiensDispo(): int
    {
        $cpt = 0;
        foreach ($this->chiens as $chien) {
            if ($chien->getAdopte() == false) {
                $cpt++;
            }
        }
        return $cpt;
    }

    public function getRacesByAnnonce(){
        $ret = [];
        foreach ($this->chiens as $chien) {
            foreach ($chien->getRaces() as $race) {
                $ret[$race->getId()] = $race;
            }
        }
        return $ret;
    }

}
