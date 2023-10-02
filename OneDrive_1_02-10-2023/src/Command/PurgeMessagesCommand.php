<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Message;

class PurgeMessagesCommand extends Command
{
    protected static $defaultName = 'app:purge-messages';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Purge des messages ayant une date de fin de diffusion inférieur à la date actuelle')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        
        $messages = $this->em->getRepository(Message::class)->findAll();
        $now = new \DateTime();
        $count = 0;

        foreach ($messages as $message) {
            if ($message->getDateFin() < $now) {
                $this->em->remove($message);
                $count++;
            }
        }

        $this->em->flush();

        $io->success('Purge finalisée. Suppression de '.$count.' message(s)');
    }
}
