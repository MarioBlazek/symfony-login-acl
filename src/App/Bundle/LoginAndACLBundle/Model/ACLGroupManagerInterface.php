<?php

namespace App\Bundle\LoginAndACLBundle\Model;

interface ACLGroupManagerInterface
{
	/**
	 * Create new instance of ACLGroupInterface
	 *
	 * @return ACLGroupInterface
	 */
	public function create();

	/**
	 * Update given group
	 *
	 * @param ACLGroupInterface $group
	 */
	public function update(ACLGroupInterface $group);

	/**
	 * Find group by name
	 *
	 * @param string $name
	 * @return ACLGroupInterface
	 * @throws \Exception
	 */
	public function getGroup($name);

	/**
	 * Check if group exist
	 *
	 * @param string $name
	 * @return bool
	 */
	public function exists($name);
}