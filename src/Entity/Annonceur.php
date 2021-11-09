<?php

namespace App\Entity;

use App\Repository\AnnonceurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnonceurRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups" = {"read:utilisateur"}}
 * )
 */
class Annonceur extends Utilisateur
{
    /**
     * @ORM\OneToMany(targetEntity=DemandeAdoption::class, mappedBy="annonceur")
     */
    private Collection $demandeAdoptions;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="annonceur")
     */
    private Collection $annonces;

    public function __construct()
    {
        parent::__construct();
        $this->demandeAdoptions = new ArrayCollection();
        $this->annonces = new ArrayCollection();
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        $roles[] = 'ROLE_ANNONCEUR';
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

    public function getCountAnnoncesAPourvoir(): int
    {
        $cpt = 0;

        foreach ($this->getAnnonces() as $annonce) {

            if ($annonce->getAnnonceur() && $annonce->getAPourvoir() == true && !$annonce->getChiens()->isEmpty() ) {
                $cpt++;
            }
        }
        return $cpt;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function getCountAnnoncesPourvues(): int
    {
        $cpt = 0;

        foreach ($this->getAnnonces() as $annonce) {
            if ($annonce->getAnnonceur() && $annonce->getAPourvoir() == false) {
                $cpt++;
            }
        }
        return $cpt;
    }


}