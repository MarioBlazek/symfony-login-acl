<?php

namespace App\Bundle\LoginAndACLBundle\Utilities;

use App\Bundle\LoginAndACLBundle\Model\ACLGroupManagerInterface;
use App\Bundle\LoginAndACLBundle\Model\ACLRoleManagerInterface;

class RoleHandler
{
	/**
	 * @var ACLRoleManagerInterface
	 */
	private $manager;
	/**
	 * @var ACLGroupManagerInterface
	 */
	private $groupManager;

	/**
	 * Constructor
	 *
	 * @param ACLRoleManagerInterface $manager
	 * @param ACLGroupManagerInterface $groupManager
	 */
	public function __construct(ACLRoleManagerInterface $manager, ACLGroupManagerInterface $groupManager)
	{
		$this->manager = $manager;
		$this->groupManager = $groupManager;
	}

	/**
	 * Create new role
	 *
	 * @param string $name
	 * @param null|string $group
	 * @return mixed
	 */
	public function create($name, $group = null)
	{
		$role = $this->manager->getRoleOrCreateIfNotExists($name);
		$role->setName($name);

		$this->manager->update($role);

		if ($group !== null && $this->groupManager->exists($group)) {
			$group = $this->groupManager->getGroup($group);
			$group->addRole($role);
			$this->groupManager->update($group);
		}

		return $role;
	}
}