<?php

namespace App\DataFixtures;

use App\Entity\Transcript;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TranscriptFixtures extends Fixture
{
    var $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function load(ObjectManager $manager)
    {

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
                $manager->persist($transcript);
            } else {
                $this->logger->error('skipping ' . $solution);
            }

        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
