<?php

namespace App\Bundle\LoginAndACLBundle\Model;

interface ACLGroupInterface
{
	/**
	 * Checks if current group has parent group
	 *
	 * @return boolean
	 */
	public function hasParent();
}