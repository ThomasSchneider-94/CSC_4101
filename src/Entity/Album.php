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
    private ?string $description = null;
    
    #[ORM\ManyToOne(inversedBy: 'albums')]
    private ?Member $member = null;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Generique::class)]
    private Collection $generiques;

    public function __construct()
    {
        $this->generiques = new ArrayCollection();
    }
    
    public function __toString() {
        return $this->description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /* Gestion de la description */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /* Gestion du propriétaire */
    public function getMember(): ?Member
    {
        return $this->member;
    }
    
    public function setMember(?Member $member): static
    {
        $this->member = $member;
        
        return $this;
    }
    
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
}
