<?php

namespace Fintek\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sync
 *
 * @ORM\Table(name="sync")
 * @ORM\Entity(repositoryClass="Fintek\AgentBundle\Repository\SyncRepository")
 */
class Sync
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
     * @ORM\Column(name="last_sync", type="string")
     */
    private $last_sync;

    /**
     * @var string
     *
     * @ORM\Column(name="ciid", type="string", unique=true)
     */
    private $ciid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Sync
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set lastSync
     *
     * @param string $lastSync
     *
     * @return Sync
     */
    public function setLastSync($lastSync)
    {
        $this->last_sync = $lastSync;

        return $this;
    }

    /**
     * Get lastSync
     *
     * @return string
     */
    public function getLastSync()
    {
        return $this->last_sync;
    }

    /**
     * Set ciid
     *
     * @param string $ciid
     *
     * @return Sync
     */
    public function setCiid($ciid)
    {
        $this->ciid = $ciid;

        return $this;
    }

    /**
     * Get ciid
     *
     * @return string
     */
    public function getCiid()
    {
        return $this->ciid;
    }
}
