<?php

namespace App\Bundle\LoginAndACLBundle\Model;

use App\Bundle\LoginAndACLBundle\Entity\ACLRole;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;

class ACLRoleManager implements ACLRoleManagerInterface
{
	/**
	 * @var ObjectManager
	 */
	private $manager;

	public function __construct(ObjectManager $manager)
	{
		$this->manager = $manager;
	}

	/**
	 * Get role by name or return null
	 *
	 * @param string $name
	 * @return \App\Bundle\LoginAndACLBundle\Entity\ACLRole
	 */
	public function getRole($name)
	{
		$role = $this->manager->getRepository('ACLBundle:ACLRole')->findOneBy(array(
			'name' => $name,
		));

		return $role;
	}

	/**
	 * Create new ACLRole
	 *
	 * @return ACLRole
	 */
	public function create()
	{
		return new ACLRole();
	}

	/**
	 * Update and persist
	 *
	 * @param ACLRoleInterface $role
	 * @param bool $flush
	 * @return ACLRoleInterface
	 */
	public function update(ACLRoleInterface $role, $flush = true)
	{
		$role->setHash(hash('md5', $role->getName()));
		$role->setUpdatedAt(new DateTime());

		$this->manager->persist($role);

		if ($flush) {
			$this->manager->flush();
		}

		return $role;
	}

	/**
	 * Get role or create new
	 *
	 * @param string $name
	 * @return ACLRole
	 */
	public function getRoleOrCreateIfNotExists($name)
	{
		$role = $this->manager->getRepository('ACLBundle:ACLRole')->findOneBy(array(
			'name' => $name
		));

		if (null === $role) {
			return $this->create();
		}

		return $role;
	}
}