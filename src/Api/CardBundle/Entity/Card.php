<?php

namespace Api\CardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * card
 *
 * @ORM\Table(name="card")
 * @ORM\Entity(repositoryClass="Api\CardBundle\Repository\cardRepository")
 */
class Card
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cardNumber", type="string", length=255)
     */
    private $cardNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="pin", type="integer")
     */
    private $pin;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cardNumber
     *
     * @param string $cardNumber
     *
     * @return card
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get cardNumber
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set pin
     *
     * @param integer $pin
     *
     * @return card
     */
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * Get pin
     *
     * @return int
     */
    public function getPin()
    {
        return $this->pin;
    }
}

