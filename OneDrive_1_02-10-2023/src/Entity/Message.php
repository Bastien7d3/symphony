<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"detail", "list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * @Serializer\Groups({"detail", "list"})
     */
    private $texte;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Serializer\Groups({"detail", "list"})
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({"detail", "list"})
     */
    private $dateFin;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Device", inversedBy="messages")
     * @Serializer\Groups({"detail", "list"})
     */
    private $devices;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Device")
     * @ORM\JoinColumn(nullable=false)
     */
    private $emetteur;

    public function __construct()
    {
        $this->devices = new ArrayCollection();
        $this->emetteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * @return Collection|Device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        if ($this->devices->contains($device)) {
            $this->devices->removeElement($device);
        }

        return $this;
    }

    public function getEmetteur(): ?Device
    {
        return $this->emetteur;
    }

    public function setEmetteur(?Device $emetteur): self
    {
        $this->emetteur = $emetteur;

        return $this;
    }

}
