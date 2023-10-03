<?php

namespace App\Entity;

use App\Repository\GeneriqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GeneriqueRepository::class)]
class Generique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $anime = null;
    
    #[ORM\Column(length: 255)]
    private ?string $type = null;
    
    #[ORM\Column]
    private ?int $numero = null;
    
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $artiste = null;

    #[ORM\ManyToOne(inversedBy: 'generiques')]
    private ?Album $album = null;
    
    public function __toString() {
        return $this->anime." - ".$this->type." ".$this->numero;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /* Gestion de l'animé */
    public function getAnime(): ?string
    {
        return $this->anime;
    }
    
    public function setAnime(string $anime): static
    {
        $this->anime = $anime;
        
        return $this;
    }
    
    /* Gestion du type de générique */
    public function getType(): ?string
    {
        return $this->type;
    }
    
    public function setType(string $type): static
    {
        $this->type = $type;
        
        return $this;
    }
    
    /* Gestion du numéro du générique */
    public function getNumero(): ?int
    {
        return $this->numero;
    }
    
    public function setNumero(int $numero): static
    {
        $this->numero = $numero;
        
        return $this;
    }
    
    /* Gestion du titre de la musique */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    /* Gestion de l'artiste de la musique */
    public function getArtiste(): ?string
    {
        return $this->artiste;
    }

    public function setArtiste(string $artiste): static
    {
        $this->artiste = $artiste;

        return $this;
    }

    /* Gestion de l'album */
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
