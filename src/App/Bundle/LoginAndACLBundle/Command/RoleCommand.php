<?php

namespace App\Bundle\LoginAndACLBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RoleCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritDoc}
	 */
	protected function configure()
	{
		$this->setName('acl:role:create');
		$this->setDescription('Create new role.');
		$this->setDefinition(array(
			new InputArgument('roleName', InputArgument::REQUIRED, 'Role name without ROLE_.'),
			new InputOption('group', 'g', InputOption::VALUE_REQUIRED, 'Group name.'),
		));
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$roleName = $input->getArgument('roleName');
		$group = $input->getOption('group');

		$roleHandler = $this->getContainer()->get('acl.role.handler');

		$roleHandler->create($roleName, $group);

		$output->writeln(sprintf('Role <comment>%s</comment> created.', $roleName));
	}
}
