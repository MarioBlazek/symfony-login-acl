<?php

namespace App\Bundle\LoginAndACLBundle\Utilities;

use App\Bundle\LoginAndACLBundle\Model\ACLGroupManagerInterface;
use App\Bundle\LoginAndACLBundle\Model\ACLRoleManagerInterface;
use App\Bundle\LoginAndACLBundle\Model\ACLUserInterface;
use App\Bundle\LoginAndACLBundle\Model\ACLUserManagerInterface;
use App\Bundle\LoginAndACLBundle\Entity\User;

class UserHandler
{
	/**
	 * @var ACLUserManagerInterface
	 */
	private $userManager;
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
	 * @param ACLUserManagerInterface $userManager
	 * @param ACLGroupManagerInterface $groupManager
	 * @param ACLRoleManagerInterface $roleManager
	 */
	public function __construct(ACLUserManagerInterface $userManager, ACLGroupManagerInterface $groupManager, ACLRoleManagerInterface $roleManager)
	{
		$this->userManager = $userManager;
		$this->groupManager = $groupManager;
		$this->roleManager = $roleManager;
	}

	/**
	 * Create new user
	 *
	 * @param string $username
	 * @param string $email
	 * @param string $password
	 * @param string $firstName
	 * @param string $lastName
	 * @param bool $active
	 * @return User
	 */
	public function create($username, $email, $password, $firstName, $lastName, $active)
	{
		/** @var User $user */
		$user = $this->userManager->create();
		$user->setUsername($username);
		$user->setEmail($email);
		$user->setPlainPassword($password);
		$user->setFirstName($firstName);
		$user->setLastName($lastName);
		$user->setIsActive($active);
		$this->userManager->update($user);

		return $user;
	}

	/**
	 * Enable user
	 *
	 * @param string $username
	 * @return mixed
	 */
	public function enable($username)
	{
		$user = $this->getUserByUsernameOrEmail($username);
		$user->setIsActive(true);
		$this->userManager->update($user);

		return $user;
	}

	/**
	 * Disable user
	 *
	 * @param string $username
	 * @return mixed
	 */
	public function disable($username)
	{
		$user = $this->getUserByUsernameOrEmail($username);
		$user->setIsActive(false);
		$this->userManager->update($user);

		return $user;
	}

	/**
	 * Set group|groups for user
	 *
	 * @param string $username
	 * @param array $groups
	 * @return mixed
	 */
	public function setGroups($username, array $groups)
	{
		if (!empty($groups)) {
			$user = $this->getUserByUsernameOrEmail($username);

			foreach($groups as $group) {
				$group = $this->groupManager->getGroup($group);

				$user->addGroup($group);
				$this->userManager->update($user);
			}
		}

		return $user;
	}

	/**
	 * Set role|roles for user
	 *
	 * @param string $username
	 * @param array $roles
	 * @return mixed
	 */
	public function setRoles($username, array $roles)
	{
		if (!empty($roles)) {
			$user = $this->getUserByUsernameOrEmail($username);

			foreach ($roles as $role) {
				$role = $this->roleManager->getRole($role);

				$user->addRole($role);
				$this->userManager->update($user);
			}
		}

		return $user;
	}


	/**
	 * Find user by username or email
	 *
	 * @param string $username
	 * @return mixed
	 */
	protected function getUserByUsernameOrEmail($username)
	{
		return $this->userManager->getUser($username);
	}
}