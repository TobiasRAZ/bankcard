<?php

namespace Fintek\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agent
 *
 * @ORM\Table(name="agent")
 * @ORM\Entity(repositoryClass="Fintek\AgentBundle\Repository\AgentRepository")
 */
class Agent
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", length=12, unique=true)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="cyclos_id", type="string", length=255, unique=true)
     */
    private $cyclosId;


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
     * Set name
     *
     * @param string $name
     *
     * @return Agent
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Agent
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set cin
     *
     * @param string $cin
     *
     * @return Agent
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set cyclosId
     *
     * @param string $cyclosId
     *
     * @return Agent
     */
    public function setCyclosId($cyclosId)
    {
        $this->cyclosId = $cyclosId;

        return $this;
    }

    /**
     * Get cyclosId
     *
     * @return string
     */
    public function getCyclosId()
    {
        return $this->cyclosId;
    }

    public function toArray() {
        $historic = array();
        foreach ($this as $key => $value)                
            $historic[$key] = $value;
        return $historic;
    }
}

