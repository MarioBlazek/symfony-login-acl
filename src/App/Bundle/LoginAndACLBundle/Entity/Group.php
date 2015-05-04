<?php

namespace App\Bundle\LoginAndACLBundle\Entity;

use App\Bundle\LoginAndACLBundle\Model\ACLGroupInterface;
use App\Bundle\LoginAndACLBundle\Entity\ACLRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="acl_group")
 * @ORM\Entity()
 */
class Group implements ACLGroupInterface
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
	 * @ORM\OneToMany(targetEntity="Group", mappedBy="parent")
	 */
	private $children;

	/**
	 * @ORM\ManyToOne(targetEntity="Group", inversedBy="children", fetch="EAGER")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 */
	private $parent;

	/**
	 * @ORM\ManyToMany(targetEntity="ACLRole", cascade={"persist","remove"})
	 * @ORM\JoinTable(name="acl_group_roles",
	 * 		joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
	 * 		inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
	 * )
	 */
	private $roles;

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
		$this->children = new ArrayCollection();
		$this->roles = new ArrayCollection();
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
     * @return Group
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
     * Add children
     *
     * @param Group $children
     * @return Group
     */
    public function addChild(Group $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param Group $children
     */
    public function removeChild(Group $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param Group $parent
     * @return Group
     */
    public function setParent(Group $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Group
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add roles
     *
     * @param ACLRole $role
     * @return Group
     */
    public function addRole(ACLRole $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param ACLRole $role
     */
    public function removeRole(ACLRole $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Group
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
     * @return Group
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

	/**
	 * {@inheritDoc}
	 */
	public function hasParent()
	{
		return $this->parent ? true : false;
	}
}
