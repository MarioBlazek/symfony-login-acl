<?php

namespace App\Bundle\LoginAndACLBundle\Model;

interface ACLGroupManagerInterface
{
	public function create();

	public function update(ACLGroupInterface $group);

	public function getGroup($name);

	public function exists($name);
}