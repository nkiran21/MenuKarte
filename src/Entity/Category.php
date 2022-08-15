<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Gericht::class)]
    private Collection $gerichte;

    //#[ORM\OneToMany(mappedBy: 'categories', targetEntity: Gericht::class)]
    // private ?Gericht $gericht = null;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->gerichte = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    // public function getGericht(): ?Gericht
    // {
    //     return $this->gericht;
    // }

    // public function setGericht(?Gericht $gericht): self
    // {
    //     $this->gericht = $gericht;

    //     return $this;
    // }

    public function __toString(){
        return $this->name;
    }

    /**
     * @return Collection<int, Gericht>
     */
    public function getGerichte(): Collection
    {
        return $this->gerichte;
    }

    public function addGerichte(Gericht $gerichte): self
    {
        if (!$this->gerichte->contains($gerichte)) {
            $this->gerichte->add($gerichte);
            $gerichte->setCategory($this);
        }

        return $this;
    }

    public function removeGerichte(Gericht $gerichte): self
    {
        if ($this->gerichte->removeElement($gerichte)) {
            // set the owning side to null (unless already changed)
            if ($gerichte->getCategory() === $this) {
                $gerichte->setCategory(null);
            }
        }

        return $this;
    }


}
