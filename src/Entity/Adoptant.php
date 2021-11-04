<?php

namespace App\Entity;

use App\Repository\AdoptantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdoptantRepository::class)
 */
class Adoptant extends Utilisateur
{
    /**
     * @ORM\OneToMany(targetEntity=DemandeAdoption::class, mappedBy="adoptant")
     */
    private Collection $demandeAdoptions;

    public function __construct()
    {
        parent::__construct();
        $this->demandeAdoptions = new ArrayCollection();
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        $roles[] = 'ROLE_ADOPTANT';
        return array_unique($roles);
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