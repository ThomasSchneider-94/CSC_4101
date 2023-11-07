<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Generique::class)]
    private Collection $generiques;

    #[ORM\OneToOne(mappedBy: 'album', cascade: ['persist', 'remove'])]
    private ?Member $member = null;

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

    /* Gestion du propriétaire */
    
    /** Gestion des génériques
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
            $generique->setAlbum($this);
        }

        return $this;
    }

    public function removeGenerique(Generique $generique): static
    {
        if ($this->generiques->removeElement($generique)) {
            // set the owning side to null (unless already changed)
            if ($generique->getAlbum() === $this) {
                $generique->setAlbum(null);
            }
        }

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        // unset the owning side of the relation if necessary
        if ($member === null && $this->member !== null) {
            $this->member->setAlbum(null);
        }

        // set the owning side of the relation if necessary
        if ($member !== null && $member->getAlbum() !== $this) {
            $member->setAlbum($this);
        }

        $this->member = $member;

        return $this;
    }


}
