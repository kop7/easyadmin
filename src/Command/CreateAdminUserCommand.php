<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(name: 'app:create-admin-user', description: 'Creates the default admin user if missing.')]
class CreateAdminUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Admin email', 'admin@example.com')
            ->addArgument('password', InputArgument::OPTIONAL, 'Admin password', 'admin123');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = (string) $input->getArgument('email');
        $password = (string) $input->getArgument('password');

        if ($this->userRepository->findOneBy(['email' => $email]) !== null) {
            $output->writeln('<info>Admin user already exists.</info>');

            return Command::SUCCESS;
        }

        $user = (new User())
            ->setEmail($email)
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('');

        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln(sprintf('<info>Admin user %s created.</info>', $email));

        return Command::SUCCESS;
    }
}
