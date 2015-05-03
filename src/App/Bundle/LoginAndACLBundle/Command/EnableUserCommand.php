<?php

namespace App\Bundle\LoginAndACLBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EnableUserCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritDoc}
	 */
	protected function configure()
	{
		$this->setName('acl:user:enable');
		$this->setDescription('Enables or disables given user.');
		$this->setDefinition(array(
			new InputArgument('username', InputArgument::REQUIRED, 'Username or email.'),
			new InputOption('disable', '-d', InputOption::VALUE_NONE, 'Set option to disable user.')
		));
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$username = $input->getArgument('username');
		$disable = $input->getOption('disable');

		$userHandler = $this->getContainer()->get('acl.user.handler');

		if (!$disable) {
			$userHandler->enable($username);
		} else {
			$userHandler->disable($username);
		}

		$output->writeln(sprintf('User <comment>%s</comment> enabled/disabled successful.', $username));
	}
}