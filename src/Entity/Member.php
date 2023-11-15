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

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Playlist::class)]
    private Collection $playlists;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Album::class)]
    private Collection $albums;

    #[ORM\OneToOne(mappedBy: 'member', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->generiques = new ArrayCollection();
        $this->playlists = new ArrayCollection();
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
    public function getAlbums(): Collection
    {
        return $this->albums;
    }
    
    public function addAlbum(Album $album): static
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->setMember($this);
        }
        
        return $this;
    }
    
    public function removeAlbum(Album $album): static
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getMember() === $this) {
                $album->setMember(null);
            }
        }
        
        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->setCreator($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getCreator() === $this) {
                $playlist->setCreator(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setMember(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getMember() !== $this) {
            $user->setMember($this);
        }

        $this->user = $user;

        return $this;
    }
}
