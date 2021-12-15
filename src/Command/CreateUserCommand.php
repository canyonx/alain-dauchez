<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserCommand extends Command
{
    private $em;
    private $encoder;
    protected static $defaultName = 'app:create-user';

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'The username of user')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new User();

        $user->setEmail($input->getArgument('username'));

        $password = $this->encoder->hashPassword($user, $input->getArgument('password'));
        $user->setPassword($password);

        $user->setRoles(['ROLE_AUTEUR'])
            ->setPrenom('')
            ->setNom('')
            ->setTelephone('');

        dump($user);

        $this->em->persist($user);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
