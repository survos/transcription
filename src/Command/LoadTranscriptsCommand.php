<?php

namespace App\Command;

use App\Entity\Transcript;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoadTranscriptsCommand extends Command
{
    protected static $defaultName = 'app:load-transcripts';

    private $em;
    public function __construct(EntityManagerInterface $em, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        foreach (glob('../data/nachotime/*.mp3') as $filename) {
            $solution = str_replace('.mp3', '.solution', $filename);
            if (file_exists($solution)) {
                $name = basename($filename, '.mp3');
                $transcript = (new Transcript())
                    ->setCode($name)
                    ->setName($name)
                    ->setFilename($filename)
                    ->setText(file_get_contents($solution));
                $attempt = str_replace('.mp3', '.tac', $filename);
                if (file_exists($attempt)) {
                    $transcript->setAttempt(file_get_contents($attempt));
                }
                $this->em->persist($transcript);
            } else {
                $io->error('skipping ' . $solution);
            }

        }

        $this->em->flush();

        $io->success('Transcripts Loaded');
    }

}
