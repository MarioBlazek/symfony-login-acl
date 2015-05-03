<?php

namespace App\Bundle\LoginAndACLBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetPasswordCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritDoc}
	 */
	protected function configure()
	{
		$this->setName('acl:user:reset-password');
		$this->setDescription('Reset the password of a user.');
		$this->setDefinition(array(
			new InputArgument('username', InputArgument::REQUIRED, 'Username or email'),
			new InputArgument('password', InputArgument::REQUIRED, 'Password')
		));
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$username = $input->getArgument('username');
		$password = $input->getArgument('password');

		$userHandler = null; // get user handler from service
		// reset password

		$output->writeln(sprintf('Password for <comment>%s</comment> successfully changed.', $username));
	}

	/**
	 * {@inheritDoc}
	 */
	protected function interact(InputInterface $input, OutputInterface $output)
	{
		if (!$input->getArgument('username')) {
			$username = $this->getHelper('dialog')->askAndValidate(
				$output,
				'Please enter a username:',
				function ($username) {
					if (empty($username)) {
						throw new \Exception('Username can not be empty');
					}

					return $username;
				}
			);

			$input->setArgument('username', $username);
		}

		if (!$input->getArgument('password')) {
			$password = $this->getHelper('dialog')->askAndValidate(
				$output,
				'Please enter new password:',
				function ($password) {
					if (empty($password)) {
						throw new \Exception('Password can not be empty');
					}

					return $password;
				}
			);

			$input->setArgument('password', $password);
		}
	}
}