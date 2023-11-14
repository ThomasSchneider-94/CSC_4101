<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?bool $publiee = null;

    #[ORM\ManyToOne(inversedBy: 'playlists')]
    private ?Member $creator = null;

    #[ORM\ManyToMany(targetEntity: Generique::class, inversedBy: 'playlists')]
    private Collection $generiques;

    public function __construct()
    {
        $this->generiques = new ArrayCollection();
    }
    
    public function __toString() {
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function isPubliee(): ?bool
    {
        return $this->publiee;
    }

    public function setPubliee(bool $publiee): static
    {
        $this->publiee = $publiee;

        return $this;
    }

    public function getCreator(): ?Member
    {
        return $this->creator;
    }

    public function setCreator(?Member $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection<int, Generique>
     */
    public function getGeneriques(): Collection
    {
        return $this->generiques;
    }

    public function addGenerique(Generique $generique): static
    {
        if (!$this->generiques->contains($generique)) {
            $this->generiques->add($generique);
        }

        return $this;
    }

    public function removeGenerique(Generique $generique): static
    {
        $this->generiques->removeElement($generique);

        return $this;
    }
}
