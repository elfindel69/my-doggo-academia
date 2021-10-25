<?php

namespace App\Entity;

use App\Repository\DemandeAdoptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeAdoptionRepository::class)
 */
class DemandeAdoption
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Annonceur::class, inversedBy="demandeAdoptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Annonceur $annonceur;

    /**
     * @ORM\ManyToOne(targetEntity=Adoptant::class, inversedBy="demandeAdoptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Adoptant $adoptant;

    /**
     * @ORM\ManyToMany(targetEntity=Chien::class, inversedBy="demandeAdoptions")
     */
    private ArrayCollection $chiens;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $acceptee;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="demandesAdoption")
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonce;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="demandeAdoption")
     */
    private $messages;

    public function __construct()
    {
        $this->chiens = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAdoptant(): ?Adoptant
    {
        return $this->adoptant;
    }

    public function setAdoptant(?Adoptant $adoptant): self
    {
        $this->adoptant = $adoptant;

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
        }

        return $this;
    }

    public function removeChien(Chien $chien): self
    {
        $this->chiens->removeElement($chien);

        return $this;
    }

    public function getAcceptee(): ?bool
    {
        return $this->acceptee;
    }

    public function setAcceptee(?bool $acceptee): self
    {
        $this->acceptee = $acceptee;

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

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setDemandeAdoption($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getDemandeAdoption() === $this) {
                $message->setDemandeAdoption(null);
            }
        }

        return $this;
    }
}
