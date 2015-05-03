<?php

namespace App\Bundle\LoginAndACLBundle\Model;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Serializable;

interface ACLUserInterface extends AdvancedUserInterface, Serializable
{

}