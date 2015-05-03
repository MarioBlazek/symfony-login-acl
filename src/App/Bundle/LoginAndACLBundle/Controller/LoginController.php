<?php

namespace App\Bundle\LoginAndACLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LoginController extends Controller
{
	/**
	 * Show login form
	 *
	 * @return Response
	 */
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

	/**
	 * Login check action
	 */
	public function loginCheckAction()
	{

	}

	/**
	 * Display homepage after successful login
	 */
	public function showHomepageAfterLoginAction()
	{
		$securityAuthCheck = $this->get('security.authorization_checker');
		if (!$securityAuthCheck->isGranted('IS_AUTHENTICATED_FULLY')) {
			throw $this->createAccessDeniedException();
		}

		return $this->render('ACLBundle:Homepage:index.html.twig', array(
			'user' => $this->getUser(),
		));
	}
}