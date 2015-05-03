<?php

namespace App\Bundle\LoginAndACLBundle\Model;

interface ACLUserManagerInterface
{
	public function create();

	public function update(ACLUserInterface $user);

	public function getUser($usernameOrEmail);
}