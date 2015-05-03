<?php

namespace App\Bundle\LoginAndACLBundle\Controller;

use App\Bundle\LoginAndACLBundle\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
	/**
	 * Show form
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function showAction()
	{
		$user = $this->get('acl.user.manager')->create();
		$form = $this->createForm(new UserType(), $user, array(
			'action' => $this->generateUrl('acl_user_handle_form'),
			'method' => 'POST',
		));

		return $this->render('ACLBundle:User:form.html.twig', array(
			'form' =>$form->createView(),
		));
	}

	/**
	 * Handle user form
	 *
	 * needs implementation
	 */
	public function handleAction(Request $request)
	{
		$user = $this->get('acl.user.manager')->create();
		$form = $this->createForm(new UserType(), $user);

		$form->handleRequest($request);

		if ($form->isValid()) {
			// needs further implementation
			$this->get('acl.user.manager')->update($user);
		}

	}

	// only for test
	public function showRolesAction()
	{
		$user = $this->getDoctrine()->getRepository('ACLBundle:User')
			->find(1);

		var_dump($user->getRoles());
	}
}