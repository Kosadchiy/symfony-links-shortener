<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinksRepository")
 * @ORM\Table(name="links")
 */
class Link
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable=true)
     */
    private $short_url;

    /**
     * @var \DateTime  $created_at
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime") 
     * 
     */
    private $created_at;

    /**
     * @var \DateTime  $updated_at
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime") 
     * 
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getShortUrl(): ?string
    {
        return $this->short_url;
    }

    public function setShortUrl(string $short_url): self
    {
        $this->short_url = $short_url;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
