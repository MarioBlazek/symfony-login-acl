<?php

namespace App\Bundle\LoginAndACLBundle\Model;

interface ACLRoleManagerInterface
{
	/**
	 * Get role by name or return null
	 *
	 * @param string $name
	 * @return ACLRoleInterface
	 */
	public function getRole($name);

	/**
	 * Create new ACLRoleInterface
	 *
	 * @return ACLRoleInterface
	 */
	public function create();

	/**
	 * Update and persist
	 *
	 * @param ACLRoleInterface $role
	 * @param bool $flush
	 * @return ACLRoleInterface
	 */
	public function update(ACLRoleInterface $role, $flush = true);

	/**
	 * Get role or create new
	 *
	 * @param string $name
	 * @return ACLRoleInterface
	 */
	public function getRoleOrCreateIfNotExists($name);
}