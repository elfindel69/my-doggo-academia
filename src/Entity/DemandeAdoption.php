<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\DemandeAdoptionRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeAdoptionRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups" = {"read:demande", "read:utilisateur", "read:chien"}}
 * )
 */
class DemandeAdoption
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:demande"})
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Annonceur::class, inversedBy="demandeAdoptions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:demande"})
     */
    private ?Annonceur $annonceur;

    /**
     * @ORM\ManyToOne(targetEntity=Adoptant::class, inversedBy="demandeAdoptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Adoptant $adoptant;

    /**
     * @ORM\ManyToMany(targetEntity=Chien::class, inversedBy="demandesAdoption")
     * @Groups({"read:demande"})
     */
    private Collection $chiens;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"read:demande"})
     */
    private ?bool $acceptee;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="demandesAdoption")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:demande"})
     */
    private ?Annonce $annonce;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="demandeAdoption", cascade={"persist"}, orphanRemoval=true)
     */
    private Collection $messages;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $dateCreation;

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

    public function getDateCreation(): ?DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function isThereUnreadMessages(Utilisateur $user): bool
    {
        $bool = false;

        foreach ($this->messages as $message) {
            if (!$message->getEstLu() && $message->getDestinataire() == $user) {
                $bool = true;
            }
        }

        return $bool;
    }

    public function nbUnreadMessages(Utilisateur $user): int
    {
        $cpt = 0;
        foreach ($this->messages as $message) {
            if (!$message->getEstLu() && $message->getDestinataire() == $user) {
                $cpt++;
            }
        }
        return $cpt;
    }
}
