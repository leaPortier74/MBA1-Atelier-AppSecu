<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SongRepository::class)
 */
class Song
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="songs")
     */
    private $Album;

    /**
     * @ORM\ManyToMany(targetEntity=Artist::class, inversedBy="songs")
     */
    private $Artist;

    public function __construct()
    {
        $this->Artist = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->Album;
    }

    public function setAlbum(?Album $Album): self
    {
        $this->Album = $Album;

        return $this;
    }

    /**
     * @return Collection|Artist[]
     */
    public function getArtist(): Collection
    {
        return $this->Artist;
    }

    public function addArtist(Artist $artist): self
    {
        if (!$this->Artist->contains($artist)) {
            $this->Artist[] = $artist;
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        $this->Artist->removeElement($artist);

        return $this;
    }
}
