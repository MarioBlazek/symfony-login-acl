<?php

namespace App\Bundle\LoginAndACLBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GroupCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritDoc}
	 */
	protected function configure()
	{
		$this->setName('acl:group:add');
		$this->setDescription('Create new group.');
		$this->setDefinition(array(
			new InputArgument('groupName', InputArgument::REQUIRED, 'Group name.'),
			new InputOption('parent', 'p', InputArgument::OPTIONAL, 'Parent group.'),
			new InputOption('roles', 'r', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'List of roles.'),
		));
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$groupName = $input->getArgument('groupName');
		$parent = $input->getOption('parent');
		$roles = $input->getOption('roles');

		$rolesArray = array_filter($roles);

		$handler = $this->getContainer()->get('acl.group.handler');
		$handler->create($groupName, $parent, $rolesArray);

		$output->writeln(sprintf("Group <comment>%s</comment> created.", $groupName));
	}

}