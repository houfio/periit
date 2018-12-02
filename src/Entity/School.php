<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SchoolRepository")
 */
class School
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Level")
     * @ORM\JoinTable(
     *     name="school_levels",
     *     joinColumns={@ORM\JoinColumn(name="school_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="level_id", referencedColumnName="id")}
     * )
     */
    private $levels;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    public function __construct()
    {
        $this->levels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevels(): ?Collection
    {
        return $this->levels;
    }

    public function addLevel(Level $level): self
    {
        $this->levels[] = $level;

        return $this;
    }

    public function removeLevel(Level $level): self
    {
        $this->levels->removeElement($level);

        return $this;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
