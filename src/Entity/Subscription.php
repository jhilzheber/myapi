<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriptionRepository")
 */
class Subscription
{
    /**
     * @Groups("subscriptions")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @SWG\Property(description="The name of the subscription.")
     * @Groups("subscriptions")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @SWG\Property(description="The slogan of the subscription.")
     * @Groups("subscriptions")
     * @ORM\Column(type="string", length=255)
     */
    private $slogan;

    /**
     * @SWG\Property(description="The url of the subscription.")
     * @Groups("subscriptions")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @SWG\Property(description="The list of users of the subscription.")
     * @Groups("subscriptions")
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="subscription")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getSlogan(): ?string
    {
        return $this->slogan;
    }

    public function setSlogan(string $slogan): self
    {
        $this->slogan = $slogan;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection|user[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }
}
