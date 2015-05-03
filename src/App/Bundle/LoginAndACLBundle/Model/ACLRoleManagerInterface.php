<?php

namespace App\Bundle\LoginAndACLBundle\Model;

interface ACLRoleManagerInterface
{
	public function getRole($name);

	public function create();

	public function update(ACLRoleInterface $role, $flush = true);

	public function getRoleOrCreateIfNotExists($name);
}