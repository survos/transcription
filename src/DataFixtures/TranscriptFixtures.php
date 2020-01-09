<?php

namespace App\DataFixtures;

use App\Entity\Transcript;
use App\Entity\User;
use App\Entity\UserTranscript;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use MsgPhp\User\Infrastructure\Doctrine\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use MsgPhp\Domain\Factory\DomainObjectFactory;
use MsgPhp\User\UserId;
use MsgPhp\User\Command\CreateUser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TranscriptFixtures extends Fixture
{
    var $logger;
    var $factory;
    var $bus;
    var $userRepository;
    public function __construct(LoggerInterface $logger,
                                DomainObjectFactory $factory, MessageBusInterface $bus,
                                UserRepository $userRepository)
    {
        $this->logger = $logger;
        $this->bus = $bus;
        $this->factory = $factory;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager)
    {
        /** @var DomainObjectFactory $factory */
        /** @var MessageBusInterface $bus */
        /*
        $this->bus->dispatch(new CreateUser([
            'id' => $this->factory->create(UserId::class),
            'email' => 'tt@gmail.com',
            'password' => 'tt'
        ]));
        */

        /** @var User $user */
        if (!$user = $this->userRepository->findByUsername($username = 'tt@example.com')) {
            throw new \Exception("$username not found.");
        }

        foreach (glob('../data/audio/*.html') as $filename) {
            $code = basename($filename);
            dump($filename);
            $crawler = new Crawler(file_get_contents($filename));

            if ($titleNode = $crawler->filter('title')) {
                try {
                    $title = $titleNode->text();
                    $rootUrl = $titleNode->getUri();
                } catch (\Exception $e) {
                    $title = $e->getMessage();
                }
            }

            if (preg_match('/(.*?)(\d+)/', $title, $m)) {
                $name = $m[1];
                $idx = $m[2];
            } else {
                die("Bad title");
            }

            if ($source = $crawler->filter('source')->first()) {
                $src = $source->attr('src');
            } else {
                $src = 'missing src';
            }

            if ($solutionNode = $crawler->filter($selector = 'details')->first()) {
                try {
                    $solution = $solutionNode->html();
                } catch (\Exception $e) {
                    $solution = 'missing solution!';
                    // die("Can't find $selector in $filename");
                }
            }

                $transcript = (new Transcript())
                    ->setCode($code)
                    ->setName($name)
                    ->setFilename($src)
                    ->setText($solution);

                // use idx?
                $attempt = '../data/audio/' . $idx . '.tac';
                dump($attempt);
                // $attempt = str_replace('code', '.html', $filename);
                if (file_exists($attempt)) {
                    $attemptText = file_get_contents($attempt);
                    $userTranscript = (new UserTranscript())
                        ->setUser($user)
                        ->setTranscript($transcript)
                        ->setAttempt($attemptText)
                        ->setParagraphs(explode("\n", $attemptText));
                    $manager->persist($userTranscript);
                    $user->addUserTranscript($userTranscript);
                    // $transcript->setAttempt($attemptText);
                } else {
                    print("Missing " . $attempt);
                    // die($attempt);
                }
                $manager->persist($transcript);

        }

        $manager->flush();
    }
}
