<?php

namespace App\Bundle\LoginAndACLBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
	/**
	 * Builds a form
	 *
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('firstName', 'text');
		$builder->add('lastName', 'text');
		$builder->add('email', 'email', array(
			'required' => false,
		));
		$builder->add('isActive', 'checkbox');
		$builder->add('username', 'text');
		$builder->add('plainPassword', 'password');
		$builder->add('save', 'submit');
	}

	/**
	 * Sets User entity as data class
	 * {@inheritDoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'App\Bundle\LoginAndACLBundle\Entity\User',
		));
	}

	/**
	 * Returns the name of this type.
	 *
	 * @return string The name of this type
	 */
	public function getName()
	{
		return 'user_type';
	}
}