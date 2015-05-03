<?php

namespace App\Bundle\LoginAndACLBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserRoleCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritDoc}
	 */
	protected function configure()
	{
		$this->setName('acl:user:role');
		$this->setDescription('Set role for given user.');
		$this->setDefinition(array(
			new InputArgument('user', InputArgument::REQUIRED, 'User.'),
			new InputArgument('roles', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'List of roles'),
		));
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$user = $input->getArgument('user');
		$roles = $input->getArgument('roles');

		$userHandler = $this->getContainer()->get('acl.user.handler');
		$userHandler->setRoles($user, $roles);

		$output->writeln('Roles added.');
	}
}