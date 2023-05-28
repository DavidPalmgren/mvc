<?php

namespace App\Entity;

use App\Repository\LibraryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @codeCoverageIgnore
 */
#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titel = null;

    #[ORM\Column]
    private ?int $ISBN = null;

    #[ORM\Column(length: 255)]
    private ?string $författare = null;

    #[ORM\Column(length: 255)]
    private ?string $bild = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $beskrivning = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitel(): ?string
    {
        return $this->titel;
    }

    public function setTitel(string $titel): self
    {
        $this->titel = $titel;

        return $this;
    }

    public function getISBN(): ?int
    {
        return $this->ISBN;
    }

    public function setISBN(int $ISBN): self
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getFörfattare(): ?string
    {
        return $this->författare;
    }

    public function setFörfattare(string $författare): self
    {
        $this->författare = $författare;

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

    public function getBeskrivning(): ?string
    {
        return $this->beskrivning;
    }

    public function setBeskrivning(?string $beskrivning): self
    {
        $this->beskrivning = $beskrivning;

        return $this;
    }
}
