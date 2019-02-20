<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Expr\Value;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @SWG\Property(description="The name of the card.")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @SWG\Property(description="The creditCardType of the card.")
     * @ORM\Column(type="string", length=255)
     */
    private $creditCardType;

    /**
     * @SWG\Property(description="The creditCardNumber of the card.")
     * @ORM\Column(type="bigint")
     */
    private $creditCardNumber;

    /**
     * @SWG\Property(description="The currencyCode of the card.")
     * @ORM\Column(type="string", columnDefinition="ENUM ('EUR','USD','GBP')")
     */
    private $currencyCode;

    /**
     * @SWG\Property(description="The value of the card.")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $value;


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

    public function getCreditCardType(): ?string
    {
        return $this->creditCardType;
    }

    public function setCreditCardType(string $creditCardType): self
    {
        $this->creditCardType = $creditCardType;

        return $this;
    }

    public function getCreditCardNumber(): ?int
    {
        return $this->creditCardNumber;
    }

    public function setCreditCardNumber(int $creditCardNumber): self
    {
        $this->creditCardNumber = $creditCardNumber;

        return $this;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getValue(?Value $value): ?int
    {
        $this->getValue($value<'100 000');
        $this->getValue($value>'0');
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->setValue($value<'100 000');
        $this->setValue($value>'0');
        $this->value = $value;
        return $this;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
}
