<?php

namespace App\Bundle\LoginAndACLBundle\Utilities;

use App\Bundle\LoginAndACLBundle\Model\ACLGroupManagerInterface;
use App\Bundle\LoginAndACLBundle\Model\ACLRoleManagerInterface;

class GroupHandler
{
	/**
	 * @var ACLGroupManagerInterface
	 */
	private $groupManager;
	/**
	 * @var ACLRoleManagerInterface
	 */
	private $roleManager;

	/**
	 * Constructor
	 *
	 * @param ACLGroupManagerInterface $groupManager
	 * @param ACLRoleManagerInterface $roleManager
	 */
	public function __construct(ACLGroupManagerInterface $groupManager, ACLRoleManagerInterface $roleManager)
	{
		$this->groupManager = $groupManager;
		$this->roleManager = $roleManager;
	}

	/**
	 * Create new group
	 *
	 * @param string $groupName
	 * @param null $parent
	 * @param array $roles
	 * @return mixed
	 */
	public function create($groupName, $parent = null, array $roles = array())
	{
		$group = $this->groupManager->create();
		$group->setName($groupName);

		if (null !== $parent) {
			$parentGroup = $this->groupManager->getGroup($parent);
			$group->setParent($parentGroup);
		}

		if (!empty($roles)) {
			foreach($roles as $roleName) {
				$role = $this->roleManager->getRole($roleName);

				// check if role already exists
				if (null === $role) {
					$role = $this->roleManager->create();
					$role->setName($roleName);

					// update role but don't flush
					$role = $this->roleManager->update($role, false);
				}

				$group->addRole($role);
			}
		}

		$this->groupManager->update($group);

		return $group;
	}
}