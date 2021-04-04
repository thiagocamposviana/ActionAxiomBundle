<?php

namespace Mugo\ActionAxiomBundle\Command;

use eZ\Publish\API\Repository\Repository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Mugo\ActionAxiomBundle\Lib\Utils\WikipediaHelper;

class WikipediaCacheCommand extends Command {

    /**
     * @var \eZ\Publish\API\Repository\Repository
     */
    private $repository;

    private $cacheService;

    public function __construct(Repository $repository, $cacheService) {
        parent::__construct(null);
        $this->repository = $repository;
        $this->cacheService = $cacheService;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
                ->setName('mugo:wikipedia:cache')
                ->addOption(
                        'script_user', 'u', InputOption::VALUE_OPTIONAL, 'eZ Platform username (with Role containing at least Content policies: read, versionread, edit, remove, versionremove)', 'admin'
                )
                ->setDescription('Cache wikipedia articles');
    }

    protected function initialize(InputInterface $input, OutputInterface $output) {
        parent::initialize($input, $output);
        $this->repository->getPermissionResolver()->setCurrentUserReference(
                $this->repository->getUserService()->loadUserByLogin($input->getOption('script_user'))
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        WikipediaHelper::cacheRandomPortugueseArticleParagraphs();
        WikipediaHelper::cacheRandomEnglishArticleParagraphs();

        return Command::SUCCESS;
    }
}
