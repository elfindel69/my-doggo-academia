<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;

/**
 *@ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */

class Adoptant extends Utilisateur
{
    /**
     * @ORM\OneToMany(targetEntity=DemandeAdoption::class, mappedBy="adoptant")
     */
    private $demandeAdoptions;

    public function __construct()
    {
        $this->demandeAdoptions = new ArrayCollection();
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
            $demandeAdoption->setAdoptant($this);
        }

        return $this;
    }

    public function removeDemandeAdoption(DemandeAdoption $demandeAdoption): self
    {
        if ($this->demandeAdoptions->removeElement($demandeAdoption)) {
            // set the owning side to null (unless already changed)
            if ($demandeAdoption->getAdoptant() === $this) {
                $demandeAdoption->setAdoptant(null);
            }
        }

        return $this;
    }
}