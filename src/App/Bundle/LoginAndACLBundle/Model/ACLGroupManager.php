<?php

namespace App\Bundle\LoginAndACLBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;
use App\Bundle\LoginAndACLBundle\Entity\Group;
use DateTime;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ACLGroupManager implements ACLGroupManagerInterface
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
	 * Create new instance of ACLGroupInterface
	 *
	 * @return ACLGroupInterface
	 */
	public function create()
	{
		return new Group();
	}

	/**
	 * Update given group
	 *
	 * @param ACLGroupInterface $group
	 */
	public function update(ACLGroupInterface $group)
	{
		$group->setUpdatedAt(new DateTime());

		$this->manager->persist($group);
		$this->manager->flush();
	}

	/**
	 * Find group by name
	 *
	 * @param string $name
	 * @return ACLGroupInterface
	 * @throws \Exception
	 */
	public function getGroup($name)
	{
		$group = $this->manager->getRepository('ACLBundle:Group')->findOneBy(array(
			'name' => $name,
		));

		if (null === $group) {
			throw new \Exception(sprintf('Can not find group by name.', $name));
		}

		return $group;
	}

	/**
	 * Check if group exist
	 *
	 * @param string $name
	 * @return bool
	 */
	public function exists($name)
	{
		$group = $this->manager->getRepository('ACLBundle:Group')->findOneBy(array(
			'name' => $name,
		));

		return $group ? true : false;
	}
}