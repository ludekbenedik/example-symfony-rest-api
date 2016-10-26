<?php

namespace AppBundle\Command;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class GenerateSampleDataCommand extends \Symfony\Component\Console\Command\Command
{
    /** @var ObjectManager */
    private $manager;


    public function __construct(ObjectManager $manager)
    {
        parent::__construct();

        $this->manager = $manager;
    }


    protected function configure()
    {
        $this
            ->setName('app:generate:sample-data')
            ->setDescription('Generate sample data')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->writeln('Generate sanple data...');

        $entities = [];

        $entities[] = $post1 = new Post('bene', 'My first blog post', 'Lorem...');
        sleep(1);

        $entities[] = $post2 = new Post('bene', 'Symfony REST API', 'Lorem...');

        $entities[] = $comment11 = new Comment($post1, 'lb@ludekbenedik.com', 'bene', 'First comment');
        $comment11->approve();
        sleep(1);

        $entities[] = $comment12 = new Comment($post1, 'lb@ludekbenedik.com', 'bene', 'Second comment');
        $comment12->approve();
        sleep(1);

        $entities[] = $comment13 = new Comment($post1, 'lb@ludekbenedik.com', 'bene', 'Third comment');

        $this->persistEntities($entities);

        $io->writeln('Done');
    }


    private function persistEntities(array $entities)
    {
        foreach ($entities as $entity) {
            $this->manager->persist($entity);
        }

        $this->manager->flush();
    }
}
