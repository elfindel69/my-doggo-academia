<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(max = 128, min = 3, minMessage = "Le nom de la photo doit faire au moins {{ limit }} caractères", maxMessage = "Le nom de la photo doit faire maximum {{ limit }} caractères")
     */
    private ?string $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max = 128, maxMessage = "L'url' photo doit faire maximum {{ limit }} caractères")
     */
    private ?string $url;

    /**
     * @ORM\ManyToOne(targetEntity=Chien::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chien;

    public function __construct()
    {

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getChien(): ?Chien
    {
        return $this->chien;
    }

    public function setChien(?Chien $chien): self
    {
        $this->chien = $chien;

        return $this;
    }

}
