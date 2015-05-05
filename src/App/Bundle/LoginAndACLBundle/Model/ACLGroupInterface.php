<?php

namespace App\Bundle\LoginAndACLBundle\Model;

interface ACLGroupInterface
{
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId();

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Group
	 */
	public function setName($name);

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Add children
	 *
	 * @param ACLGroupInterface $children
	 * @return ACLGroupInterface
	 */
	public function addChild(ACLGroupInterface $children);

	/**
	 * Remove children
	 *
	 * @param ACLGroupInterface $children
	 */
	public function removeChild(ACLGroupInterface $children);

	/**
	 * Get children
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getChildren();

	/**
	 * Set parent
	 *
	 * @param ACLGroupInterface $parent
	 * @return ACLGroupInterface
	 */
	public function setParent(ACLGroupInterface $parent = null);

	/**
	 * Get parent
	 *
	 * @return ACLGroupInterface
	 */
	public function getParent();

	/**
	 * Add roles
	 *
	 * @param ACLRoleInterface $role
	 * @return ACLGroupInterface
	 */
	public function addRole(ACLRoleInterface $role);

	/**
	 * Remove roles
	 *
	 * @param ACLRoleInterface $role
	 */
	public function removeRole(ACLRoleInterface $role);

	/**
	 * Get roles
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getRoles();

	/**
	 * Set createdAt
	 *
	 * @param \DateTime $createdAt
	 * @return ACLGroupInterface
	 */
	public function setCreatedAt($createdAt);

	/**
	 * Get createdAt
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt();

	/**
	 * Set updatedAt
	 *
	 * @param \DateTime $updatedAt
	 * @return ACLGroupInterface
	 */
	public function setUpdatedAt($updatedAt);

	/**
	 * Get updatedAt
	 *
	 * @return \DateTime
	 */
	public function getUpdatedAt();


	/**
	 * Checks if current group has parent group
	 *
	 * @return boolean
	 */
	public function hasParent();
}