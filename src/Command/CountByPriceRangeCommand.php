<?php

namespace App\Command;

use App\Service\Offer\Model\PriceRange;
use App\Service\Offer\OfferCollection;
use App\Service\Offer\OfferCollectionFactory;
use App\Traits\LoggerRequiredTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CountByPriceRangeCommand extends Command
{
    use LoggerRequiredTrait;

    protected static $defaultName = 'app:count-by-price-range';
    protected static $defaultDescription = 'Count by price range';

    private OfferCollectionFactory $offerCollectionFactory;
    private OfferCollection $offerCollection;

    public function __construct(OfferCollection $offerCollection)
    {
        parent::__construct();
        $this->offerCollection = $offerCollection;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('min', InputArgument::REQUIRED, 'Min')
            ->addArgument('max', InputArgument::REQUIRED, 'Max');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $min = $input->getArgument('min');
        $max = $input->getArgument('max');

        if (!is_numeric($min)) {
            $io->error('Min should be numeric');
            return Command::INVALID;
        }

        if (!is_numeric($max)) {
            $io->error('Max should be numeric');
            return Command::INVALID;
        }

        $count = $this->offerCollection->countByPriceRange(new PriceRange($min, $max));

        $io->success(sprintf('Count: %d', $count));
        $this->logger->info(sprintf('Count for price range from %s to %s is %d', $min, $max, $count));

        return Command::SUCCESS;
    }
}
