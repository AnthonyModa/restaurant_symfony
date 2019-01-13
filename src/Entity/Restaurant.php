<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File()
     */
    private $image;
    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=10)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $informations;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $avis;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, max=255, minMessage="Le message est trop court")
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="restaurants", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="restaurant", orphanRemoval=true)
     */
    private $notice;

    public function __construct()
    {
        $this->notice = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getInformations(): ?string
    {
        return $this->informations;
    }

    public function setInformations(string $informations): self
    {
        $this->informations = $informations;

        return $this;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function setAvis(string $avis): self
    {
        $this->avis = $avis;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getNotice(): Collection
    {
        return $this->notice;
    }

    public function addNotice(Avis $notice): self
    {
        if (!$this->notice->contains($notice)) {
            $this->notice[] = $notice;
            $notice->setRestaurant($this);
        }

        return $this;
    }

    public function removeNotice(Avis $notice): self
    {
        if ($this->notice->contains($notice)) {
            $this->notice->removeElement($notice);
            // set the owning side to null (unless already changed)
            if ($notice->getRestaurant() === $this) {
                $notice->setRestaurant(null);
            }
        }

        return $this;
    }
}
