<?php

namespace App\Bundle\LoginAndACLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
	public function showLoginFormAction()
	{
		$authenticationUtils = $this->get('security.authentication_utils');
		$error = $authenticationUtils->getLastAuthenticationError();
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('ACLBundle:Login:index.html.twig', array(
			'last_username' => $lastUsername,
			'error'			=> $error,
		));
	}

	public function loginCheckAction()
	{

	}
}