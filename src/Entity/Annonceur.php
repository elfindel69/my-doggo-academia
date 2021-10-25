<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

class Annonceur extends Utilisateur
{
    /**
     * @ORM\OneToMany(targetEntity=DemandeAdoption::class, mappedBy="annonceur")
     */
    private ArrayCollection $demandeAdoptions;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="annonceur")
     */
    private ArrayCollection $annonces;

    public function __construct()
    {
        parent::__construct();
        $this->demandeAdoptions = new ArrayCollection();
        $this->annonces = new ArrayCollection();
    }

    /**
     * @return Collection|DemandeAdoption[]
     */
    public function getDemandeAdoptions(): Collection
    {
        return $this->demandeAdoptions;
    }

    public function addDemandeAdoption(DemandeAdoption $demandeAdoption): self
    {
        if (!$this->demandeAdoptions->contains($demandeAdoption)) {
            $this->demandeAdoptions[] = $demandeAdoption;
            $demandeAdoption->setAnnonceur($this);
        }

        return $this;
    }

    public function removeDemandeAdoption(DemandeAdoption $demandeAdoption): self
    {
        if ($this->demandeAdoptions->removeElement($demandeAdoption)) {
            // set the owning side to null (unless already changed)
            if ($demandeAdoption->getAnnonceur() === $this) {
                $demandeAdoption->setAnnonceur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setAnnonceur($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getAnnonceur() === $this) {
                $annonce->setAnnonceur(null);
            }
        }

        return $this;
    }
}