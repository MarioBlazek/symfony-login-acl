<?php

namespace App\Bundle\LoginAndACLBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserGroupCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritDoc}
	 */
	protected function configure()
	{
		$this->setName('acl:user:group');
		$this->setDescription('Set group|groups for user.');
		$this->setDefinition(array(
			new InputArgument('user', InputArgument::REQUIRED, 'User.'),
			new InputArgument('groups', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'List of groups.')
		));
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$user = $input->getArgument('user');
		$groups = $input->getArgument('groups');

		$userHandler = $this->getContainer()->get('acl.user.handler');
		$userHandler->setGroups($user, $groups);

		$output->writeln('Groups added.');
	}
}