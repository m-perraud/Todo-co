<?php

namespace App\Command;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'update:taskAuthor',
    description: 'Add a short description for your command',
)]
class UpdateTaskAuthorCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em
        
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tasks = $this->em->getRepository(Task::class)->findBy(['author' => null]);
        $anonymeId = $this->em->getRepository(User::class)->findOneByUsername('anonyme')->getId();

        if ($tasks == [])
        {
            $output->write("Aucune tâche sans auteur existante.");

            return Command::FAILURE;
        }

        foreach ($tasks as $task)
        {
            $task->setAuthor($anonymeId);
            $this->em->persist($task);
        }

        $this->em->flush();

        $output->write("Tâches sans auteurs mises à jour.");

        return Command::SUCCESS;
    }
}
