<?php

namespace App\Bundle\LoginAndACLBundle\Entity;

use App\Bundle\LoginAndACLBundle\Model\ACLRoleInterface;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="acl_role")
 * @ORM\Entity()
 */
class ACLRole implements ACLRoleInterface
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=50, unique=true)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=50, unique=true)
	 */
	private $hash;

	/**
	 * @ORM\Column(type="datetime", name="created_at")
	 */
	private $createdAt;

	/**
	 * @ORM\Column(type="datetime", name="updated_at")
	 */
	private $updatedAt;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->createdAt = new DateTime();
	}

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
     * Set name
     *
     * @param string $name
     * @return ACLRole
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
     * Set hash
     *
     * @param string $hash
     * @return ACLRole
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string 
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ACLRole
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return ACLRole
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
