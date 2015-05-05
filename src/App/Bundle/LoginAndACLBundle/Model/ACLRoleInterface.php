<?php

namespace App\Bundle\LoginAndACLBundle\Model;

interface ACLRoleInterface
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
	 * @return ACLRoleInterface
	 */
	public function setName($name);

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Set hash
	 *
	 * @param string $hash
	 * @return ACLRoleInterface
	 */
	public function setHash($hash);

	/**
	 * Get hash
	 *
	 * @return string
	 */
	public function getHash();

	/**
	 * Set createdAt
	 *
	 * @param \DateTime $createdAt
	 * @return ACLRoleInterface
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
	 * @return ACLRoleInterface
	 */
	public function setUpdatedAt($updatedAt);

	/**
	 * Get updatedAt
	 *
	 * @return \DateTime
	 */
	public function getUpdatedAt();
}