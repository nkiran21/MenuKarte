<?php

namespace App\Entity;

use App\Repository\GerichtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GerichtRepository::class)]
class Gericht
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $bild = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $beschreibung = null;

    #[ORM\Column(nullable: true)]
    private ?float $preis = null;

    #[ORM\ManyToOne(inversedBy: 'gerichte')]
    private ?Category $category = null;

    // #[ORM\ManyToOne(inversedBy: 'gericht', targetEntity: Category::class)]
    // private Collection $category;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getBeschreibung(): ?string
    {
        return $this->beschreibung;
    }

    public function setBeschreibung(?string $beschreibung): self
    {
        $this->beschreibung = $beschreibung;

        return $this;
    }

    public function getPreis(): ?float
    {
        return $this->preis;
    }

    public function setPreis(?float $preis): self
    {
        $this->preis = $preis;

        return $this;
    }

    public function getBild(): ?string
    {
        return $this->bild;
    }

    public function setBild(string $bild): self
    {
        $this->bild = $bild;

        return $this;
    }

    // /**
    //  * @return Collection<int, Category>
    //  */
    // public function getCategory(): Collection
    // {
    //     return $this->category;
    // }

    // public function addCategory(Category $category): self
    // {
    //     if (!$this->categories->contains($category)) {
    //         $this->categories->add($category);
    //         $category->setGericht($this);
    //     }

    //     return $this;
    // }

    // public function removeCategory(Category $category): self
    // {
    //     if ($this->categories->removeElement($category)) {
    //         // set the owning side to null (unless already changed)
    //         if ($category->getGericht() === $this) {
    //             $category->setGericht(null);
    //         }
    //     }

    //     return $this;
    // }

    // public function setCategory(?Category $category): self
    // {
    //     $this->category = $category;

    //     return $this;
    // }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
