<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="ContactPerson", mappedBy="company")
     */
    private $contact_persons;

    /**
     * @ORM\ManyToMany(targetEntity="Level")
     * @ORM\JoinTable(
     *     name="company_levels",
     *     joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="level_id", referencedColumnName="id")}
     * )
     */
    private $levels;

    /**
     * @ORM\ManyToMany(targetEntity="Material")
     * @ORM\JoinTable(
     *     name="company_materials",
     *     joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="material_id", referencedColumnName="id")}
     * )
     */
    private $materials;

    /**
     * @ORM\ManyToMany(targetEntity="Method")
     * @ORM\JoinTable(
     *     name="company_methods",
     *     joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="method_id", referencedColumnName="id")}
     * )
     */
    private $methods;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $zip_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $website;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function __construct()
    {
        $this->contact_persons = new ArrayCollection();
        $this->levels = new ArrayCollection();
        $this->materials = new ArrayCollection();
        $this->methods = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactPersons(): ?Collection
    {
        return $this->contact_persons;
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

    public function getMaterials(): ?Collection
    {
        return $this->materials;
    }

    public function addMaterial(Material $material): self
    {
        $this->materials[] = $material;

        return $this;
    }

    public function removeMaterial(Material $material): self
    {
        $this->materials->removeElement($material);

        return $this;
    }

    public function getMethods(): ?Collection
    {
        return $this->methods;
    }

    public function addMethod(Method $method): self
    {
        $this->methods[] = $method;

        return $this;
    }

    public function removeMethod(Method $method): self
    {
        $this->methods->removeElement($method);

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

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
}
