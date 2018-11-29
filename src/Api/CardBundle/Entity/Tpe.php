<?php

namespace Api\CardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tpe
 *
 * @ORM\Table(name="tpe")
 * @ORM\Entity(repositoryClass="Api\CardBundle\Repository\TpeRepository")
 */
class Tpe
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
     * @ORM\Column(name="imei", type="string", length=255, unique=true)
     */
    private $imei;

    /**
     * @var string
     *
     * @ORM\Column(name="mac", type="string", length=255, unique=true)
     */
    private $mac;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

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
     * Set imei
     *
     * @param string $imei
     *
     * @return Tpe
     */
    public function setImei($imei)
    {
        $this->imei = $imei;

        return $this;
    }

    /**
     * Get imei
     *
     * @return string
     */
    public function getImei()
    {
        return $this->imei;
    }

    /**
     * Set mac
     *
     * @param string $mac
     *
     * @return Tpe
     */
    public function setMac($mac)
    {
        $this->mac = $mac;

        return $this;
    }

    /**
     * Get mac
     *
     * @return string
     */
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Tpe
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
}
