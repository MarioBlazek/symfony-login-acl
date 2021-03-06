<?php

namespace App\Bundle\LoginAndACLBundle\Model;

use App\Bundle\LoginAndACLBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class ACLUserManager implements ACLUserManagerInterface
{
	/**
	 * @var EncoderFactoryInterface
	 */
	private $encoder;
	/**
	 * @var ObjectManager
	 */
	private $manager;

	public function __construct(EncoderFactoryInterface $encoder, ObjectManager $manager)
	{

		$this->encoder = $encoder;
		$this->manager = $manager;
	}

	/**
	 * Creates new user
	 *
	 * @return ACLUserInterface
	 */
	public function create()
	{
		return new User();
	}

	/**
	 * Updates given user
	 *
	 * @param ACLUserInterface $user
	 */
	public function update(ACLUserInterface $user)
	{
		$this->updatePassword($user);
		$user->setUpdatedAt(new \DateTime());

		$this->manager->persist($user);
		$this->manager->flush();
	}

	/**
	 * Find user by username of email
	 *
	 * @param string $usernameOrEmail
	 * @return ACLUserInterface
	 */
	public function getUser($usernameOrEmail)
	{
		$user = $this->getUserRepository()->loadUserByUsername($usernameOrEmail);

		return $user;
	}

	/**
	 * Update user password
	 *
	 * @param ACLUserInterface $user
	 */
	private function updatePassword(ACLUserInterface $user)
	{
		if (0 !== strlen($password = $user->getPlainPassword())) {
			$encoder = $this->encoder->getEncoder($user);
			$user->setPassword($encoder->encodePassword($password, ''));
		}
	}

	/**
	 * User repository helper
	 *
	 * @return \App\Bundle\LoginAndACLBundle\Entity\UserRepository
	 */
	private function getUserRepository()
	{
		return $this->manager->getRepository('ACLBundle:User');
	}
}