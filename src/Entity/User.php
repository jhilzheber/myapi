<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property string api_key
 * @UniqueEntity("email")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
    * @Groups("user")
    * @ORM\Id()
    * @ORM\GeneratedValue()
    * @ORM\Column(type="integer")
    * @SWG\Property(description="The unique identifier of the user.")
    */
    private $id;

    /**
     * @SWG\Property(description="The firstname of the user.")
     * @Groups("user")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @SWG\Property(description="The lastname of the user.")
     * @Groups("user")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @SWG\Property(description="The email of the user.")
     * @Groups("user")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @SWG\Property(description="The api_key of the user.")
     * @Groups("user")
     * @ORM\GeneratedValue()
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     */
    private $apiKey;

    /**
     * @SWG\Property(description="The date of subscription of the user.")
     * @Groups("user")
     * @ORM\Column(type="datetime")
     * @ORM\GeneratedValue()
     */
    private $createdAt;

    /**
     * @Groups("user")
     * @ORM\Column(type="simple_array")
     */
    private $roles = [];

    /**
     * @SWG\Property(description="The address of the user.")
     * @Groups("user")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @SWG\Property(description="The countryof the user.")
     * @Groups("user")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @SWG\Property(description="The subscriptions of the user.")
     * @ORM\ManyToOne(targetEntity="App\Entity\Subscription", inversedBy="user")
     */
    private $subscription;

    /**
     * @SWG\Property(description="The cards of the user.")
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="user")
     */
    private $card;

    public function __construct()
    {
        $this->card = new ArrayCollection();
        $this->api_key = uniqid();
        $this->roles = array('ROLE_USER');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getSubscription(): ?string
    {
        return $this->subscription;
    }


    public function getCard(): Collection
    {
        return $this->card;
    }

    /**
     * @return mixed
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    /**
     * @return Collection|card[]
     */
    public function getCards(): Collection
    {
        return $this->card;
    }

    public function addSubscription(User $user)
    {
        if ($this->subscription->$user) {
            return;
        }
        $this->subscription[] = $user;
    }
}
