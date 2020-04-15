<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StreamRepository")
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *     normalizationContext={"read"},
 *     denormalizationContext={"write"},
 *     mercure=true,
 * )
 */
class Stream
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"read", "write"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, name="secret_key")
     * @Groups({"read"})
     */
    private $key;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     * @Groups({"read"})
     */
    private $live = false;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     * @Groups({"read"})
     */
    private $viewerCount = 0;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function isLive(): ?bool
    {
        return $this->live;
    }

    public function setLive(bool $live): self
    {
        $this->live = $live;

        return $this;
    }

    public function getViewerCount(): ?int
    {
        return $this->viewerCount;
    }

    public function setViewerCount(int $viewerCount): self
    {
        $this->viewerCount = $viewerCount;

        return $this;
    }
}
