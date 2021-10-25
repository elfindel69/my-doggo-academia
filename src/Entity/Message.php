<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $contenu;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $dateEnvoi;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $estLu;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="messagesEnvoyes")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Utilisateur $expediteur;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="messageRecus")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Utilisateur $destinataire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): self
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getEstLu(): ?bool
    {
        return $this->estLu;
    }

    public function setEstLu(?bool $estLu): self
    {
        $this->estLu = $estLu;

        return $this;
    }

    public function getExpediteur(): ?Utilisateur
    {
        return $this->expediteur;
    }

    public function setExpediteur(?Utilisateur $expediteur): self
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getDestinataire(): ?Utilisateur
    {
        return $this->destinataire;
    }

    public function setDestinataire(?Utilisateur $destinataire): self
    {
        $this->destinataire = $destinataire;

        return $this;
    }
}
