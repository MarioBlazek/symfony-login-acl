<?php

namespace App\Bundle\LoginAndACLBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use App\Bundle\LoginAndACLBundle\Model\ACLUserInterface;
use App\Bundle\LoginAndACLBundle\Entity\ACLRole;
use App\Bundle\LoginAndACLBundle\Entity\Group;

/**
 * @ORM\Table(name="acl_users")
 * @ORM\Entity(repositoryClass="App\Bundle\LoginAndACLBundle\Entity\UserRepository")
 */
class User implements ACLUserInterface
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=25, unique=true)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string", length=64)
	 */
	private $password;

	/**
	 * @ORM\Column(type="string", length=50, name="first_name")
	 */
	private $firstName;

	/**
	 * @ORM\Column(type="string", length=50, name="last_name")
	 */
	private $lastName;

	/**
	 * Temporary save for plain password
	 *
	 * @var string
	 */
	private $plainPassword;

	/**
	 * @ORM\Column(type="string", length=60, unique=true)
	 */
	private $email;

	/**
	 * @ORM\Column(name="is_active", type="boolean")
	 */
	private $isActive;

	/**
	 * @ORM\Column(name="created_at", type="datetime")
	 */
	private $createdAt;

	/**
	 * @ORM\Column(name="updated_at", type="datetime")
	 */
	private $updatedAt;

	/**
	 * @ORM\ManyToMany(targetEntity="Group")
	 * @ORM\JoinTable(name="acl_user_groups",
	 * 		joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
	 * 		inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
	 * )
	 */
	private $groups;

	/**
	 * @ORM\ManyToMany(targetEntity="ACLRole")
	 * @ORM\JoinTable(name="acl_user_roles",
	 * 		joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
	 * 		inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
	 * )
	 */
	private $roles;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->isActive = false;
		$this->createdAt = new \DateTime();
		$this->groups = new ArrayCollection();
		$this->roles = new ArrayCollection();
	}

	/**
	 * Checks whether the user's account has expired.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw an AccountExpiredException and prevent login.
	 *
	 * @return bool true if the user's account is non expired, false otherwise
	 *
	 * @see AccountExpiredException
	 */
	public function isAccountNonExpired()
	{
		return true;
	}

	/**
	 * Checks whether the user is locked.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a LockedException and prevent login.
	 *
	 * @return bool true if the user is not locked, false otherwise
	 *
	 * @see LockedException
	 */
	public function isAccountNonLocked()
	{
		return true;
	}

	/**
	 * Checks whether the user's credentials (password) has expired.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a CredentialsExpiredException and prevent login.
	 *
	 * @return bool true if the user's credentials are non expired, false otherwise
	 *
	 * @see CredentialsExpiredException
	 */
	public function isCredentialsNonExpired()
	{
		return true;
	}

	/**
	 * Checks whether the user is enabled.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a DisabledException and prevent login.
	 *
	 * @return bool true if the user is enabled, false otherwise
	 *
	 * @see DisabledException
	 */
	public function isEnabled()
	{
		return $this->isActive;
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * String representation of object
	 * @link http://php.net/manual/en/serializable.seriallsize.php
	 * @return string the string representation of the object or null
	 */
	public function serialize()
	{
		return serialize(array(
			$this->id,
			$this->username,
			$this->password,
			$this->isActive,
		));
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Constructs the object
	 * @link http://php.net/manual/en/serializable.unserialize.php
	 * @param string $serialized <p>
	 * The string representation of the object.
	 * </p>
	 * @return void
	 */
	public function unserialize($serialized)
	{
		list (
			$this->id,
			$this->username,
			$this->password,
			$this->isActive
			) = unserialize($serialized);
	}

	/**
	 * Returns the roles granted to the user.
	 *
	 * <code>
	 * public function getRoles()
	 * {
	 *     return array('ROLE_USER');
	 * }
	 * </code>
	 *
	 * Alternatively, the roles might be stored on a ``roles`` property,
	 * and populated in any number of different ways when the user object
	 * is created.
	 *
	 * @return Role[] The user roles
	 */
	public function getRoles()
	{
		$roles = array();

		foreach ($this->groups as $group) {
			$groupRoles = $group->getRoles();

			foreach ($groupRoles as $groupRole) {
				$roles[] = $groupRole->getName();
			}
		}

		foreach ($this->roles as $roleName) {
			$roles[] = $roleName->getName();
		}

		return $roles;
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
		return $this->password;
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
		return null;
	}

	/**
	 * Returns the username used to authenticate the user.
	 *
	 * @return string The username
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Removes sensitive data from the user.
	 *
	 * This is important if, at any given point, sensitive information like
	 * the plain-text password is stored on this object.
	 */
	public function eraseCredentials()
	{

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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

	/**
	 * @return string
	 */
	public function getPlainPassword()
	{
		return $this->plainPassword;
	}

	/**
	 * @param string $plainPassword
	 */
	public function setPlainPassword($plainPassword)
	{
		$this->plainPassword = $plainPassword;
	}

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * @return User
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
     * Add groups
     *
     * @param Group $group
     * @return User
     */
    public function addGroup(Group $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param Group $group
     */
    public function removeGroup(Group $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add roles
     *
     * @param ACLRole $role
     * @return User
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
}
