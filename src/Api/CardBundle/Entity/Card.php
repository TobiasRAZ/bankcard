<?php

namespace Api\CardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * card
 *
 * @ORM\Table(name="card")
 * @ORM\Entity(repositoryClass="Api\CardBundle\Repository\CardRepository")
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
     * @ORM\Column(name="cardNumber", type="string", length=50)
     */
    private $cardNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="pin", type="string", length=4)
     */
    private $pin;


    /**
     * Get id
     *
     * @return integer
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
     * @return Card
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
     * @param string $pin
     *
     * @return Card
     */
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * Get pin
     *
     * @return string
     */
    public function getPin()
    {
        return $this->pin;
    }
}
