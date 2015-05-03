<?php

namespace App\Bundle\LoginAndACLBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritDoc}
	 */
	protected function configure()
	{
		$this->setName('acl:user:create');
		$this->setDescription('Create user');
		$this->setDefinition(array(
			new InputArgument('username', InputArgument::REQUIRED, 'Username'),
			new InputArgument('email', InputArgument::REQUIRED, 'User email'),
			new InputArgument('password', InputArgument::REQUIRED, 'The password'),
			new InputArgument('firstName', InputArgument::REQUIRED, 'First name'),
			new InputArgument('lastName', InputArgument::REQUIRED, 'Last name'),
			new InputOption('active', '-a', InputOption::VALUE_NONE, 'Activate user')
		));
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$username = $input->getArgument('username');
		$email = $input->getArgument('email');
		$password = $input->getArgument('password');
		$firstName = $input->getArgument('firstName');
		$lastName = $input->getArgument('lastName');
		$isActive = $input->getOption('active');

		$userHandler = $this->getContainer()->get('acl.user.handler'); // get user handler from service
		$userHandler->create($username, $email, $password, $firstName, $lastName, $isActive);
		// create user

		$output->writeln(sprintf('Created user <comment>%s</comment>.', $username));
	}

	/**
	 * {@inheritDoc}
	 */
	protected function interact(InputInterface $input, OutputInterface $output)
	{
		if (!$input->getArgument('username')) {
			$username = $this->getHelper('dialog')->askAndValidate(
				$output,
				'Please choose a username: ',
				function ($username) {
					if (empty($username)) {
						throw new \Exception('Username can not be empty');
					}

					return $username;
				}
			);

			$input->setArgument('username', $username);
		}

		if (!$input->getArgument('email')) {
			$email = $this->getHelper('dialog')->askAndValidate(
				$output,
				'Please choose a email: ',
				function ($email) {
					if (empty($email)) {
						throw new \Exception('Email can not be empty');
					}

					return $email;
				}
			);

			$input->setArgument('email', $email);
		}

		if (!$input->getArgument('password')) {
			$password = $this->getHelper('dialog')->askAndValidate(
				$output,
				'Please choose a password: ',
				function ($password) {
					if (empty($password)) {
						throw new \Exception('Password can not be empty');
					}

					return $password;
				}
			);

			$input->setArgument('password', $password);
		}

		if (!$input->getArgument('firstName')) {
			$firstName = $this->getHelper('dialog')->askAndValidate(
				$output,
				'Please enter first name: ',
				function ($firstName) {
					if (empty($firstName)) {
						throw new \Exception('First name can not be empty');
					}

					return $firstName;
				}
			);

			$input->setArgument('firstName', $firstName);
		}

		if (!$input->getArgument('lastName')) {
			$lastName = $this->getHelper('dialog')->askAndValidate(
				$output,
				'Please enter last name: ',
				function ($lastName) {
					if (empty($lastName)) {
						throw new \Exception('Last name can not be empty');
					}

					return $lastName;
				}
			);

			$input->setArgument('lastName', $lastName);
		}
	}
}