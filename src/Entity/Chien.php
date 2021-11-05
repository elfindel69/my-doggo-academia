<?php

namespace App\Entity;

use App\Repository\ChienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChienRepository::class)
 */
class Chien
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $age;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $taille;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $poids;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $lof;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $sociable;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $antecedents;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $adopte;

    /**
     * @ORM\ManyToMany(targetEntity=Race::class, inversedBy="chiens")
     * @Assert\Valid()
     */
    private Collection $races;

    /**
     * @ORM\ManyToMany(targetEntity=DemandeAdoption::class, mappedBy="chiens")
     */
    private Collection $demandesAdoption;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="chiens")
     */
    private ?Annonce $annonce;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private ?string $sexe;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="chien", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid()
     */
    private Collection $photos;


    public function __construct()
    {
        $this->races = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->demandesAdoption = new ArrayCollection();
        $this->adopte = false;
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getTaille(): ?float
    {
        return $this->taille;
    }

    public function setTaille(float $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): self
    {
        $this->poids = $poids;

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

    public function getLof(): ?bool
    {
        return $this->lof;
    }

    public function setLof(bool $lof): self
    {
        $this->lof = $lof;

        return $this;
    }

    public function getSociable(): ?bool
    {
        return $this->sociable;
    }

    public function setSociable(?bool $sociable): self
    {
        $this->sociable = $sociable;

        return $this;
    }

    public function getAntecedents(): ?string
    {
        return $this->antecedents;
    }

    public function setAntecedents(string $antecedents): self
    {
        $this->antecedents = $antecedents;

        return $this;
    }

    public function getAdopte(): ?bool
    {
        return $this->adopte;
    }

    public function setAdopte(?bool $adopte): self
    {
        $this->adopte = $adopte;

        return $this;
    }

    /**
     * @return Collection|Race[]
     */
    public function getRaces(): Collection
    {
        return $this->races;
    }

    public function addRace(Race $race): self
    {
        if (!$this->races->contains($race)) {
            $this->races[] = $race;
        }

        return $this;
    }

    public function removeRace(Race $race): self
    {
        $this->races->removeElement($race);

        return $this;
    }


    /**
     * @return Collection|DemandeAdoption[]
     */
    public function getDemandesAdoption(): Collection
    {
        return $this->demandesAdoption;
    }

    public function addDemandeAdoption(DemandeAdoption $demandeAdoption): self
    {
        if (!$this->demandesAdoption->contains($demandeAdoption)) {
            $this->demandesAdoption[] = $demandeAdoption;
            $demandeAdoption->addChien($this);
        }

        return $this;
    }

    public function removeDemandeAdoption(DemandeAdoption $demandeAdoption): self
    {
        if ($this->demandesAdoption->removeElement($demandeAdoption)) {
            $demandeAdoption->removeChien($this);
        }

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setChien($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getChien() === $this) {
                $photo->setChien(null);
            }
        }

        return $this;
    }


}
