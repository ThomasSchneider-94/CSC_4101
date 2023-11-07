<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;
    
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pseudo = null;

    #[ORM\OneToOne(inversedBy: 'member', cascade: ['persist', 'remove'])]
    private ?Album $album = null;


    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }
    
    public function __toString() {
        if ($this->pseudo == null)
        {
            return $this->nom . " " . $this->prenom;
        }
        else
        {
            return $this->pseudo;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /* Gestion du nom */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /* Gestion du prenom */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }
    
    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        
        return $this;
    }
    
    /* Gestion du pseudo */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }
    
    public function setPseudo(string|null $pseudo): static
    {
        $this->pseudo = $pseudo;
        
        return $this;
    }

    /** Gestion des collections
     * @return Collection<int, Album>
     */
    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

        return $this;
    }
}
