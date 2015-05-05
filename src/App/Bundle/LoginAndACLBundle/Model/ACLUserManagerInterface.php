<?php

namespace App\Bundle\LoginAndACLBundle\Model;

interface ACLUserManagerInterface
{
	/**
	 * Creates new user
	 *
	 * @return ACLUserInterface
	 */
	public function create();

	/**
	 * Updates given user
	 *
	 * @param ACLUserInterface $user
	 */
	public function update(ACLUserInterface $user);

	/**
	 * Find user by username of email
	 *
	 * @param string $usernameOrEmail
	 * @return ACLUserInterface
	 */
	public function getUser($usernameOrEmail);
}