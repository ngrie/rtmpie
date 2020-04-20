<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateFirstUserCommand extends Command
{
    protected static $defaultName = 'app:create-first-user';

    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, string $name = null)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Adds user "admin" with password "admin" if no user exists')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (empty($this->entityManager->getRepository(User::class)->findOneBy([]))) {
            $user = new User();
            $user->setUsername('admin');
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $io->success('Created a first user. User "admin" as username and password to login.');
        }

        return 0;
    }
}
