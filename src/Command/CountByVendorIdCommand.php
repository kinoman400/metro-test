<?php

namespace App\Command;

use App\Service\Offer\Model\PriceRange;
use App\Service\Offer\OfferCollectionFactory;
use App\Traits\LoggerRequiredTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CountByVendorIdCommand extends Command
{
    use LoggerRequiredTrait;

    protected static $defaultName = 'app:count-by-vendor-id';
    protected static $defaultDescription = 'Add a short description for your command';

    private OfferCollectionFactory $offerCollectionFactory;

    public function __construct(OfferCollectionFactory $offerCollectionFactory)
    {
        parent::__construct();
        $this->offerCollectionFactory = $offerCollectionFactory;
    }

    protected function configure(): void
    {
        $this->addArgument('vendorId', InputArgument::REQUIRED, 'Vendor ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $vendorId = $input->getArgument('vendorId');

        if ($vendorId != intval($vendorId)) {
            $io->error('Vendor Id should be integer');
            return Command::INVALID;
        }

        $vendorId = intval($vendorId);
        $count = $this->offerCollectionFactory->make()->countByVendorId($vendorId);
        $io->success(sprintf('Count: %d', $count));
        $this->logger->info(sprintf('Count for vendor Id %d is %d', $vendorId, $count));

        return Command::SUCCESS;
    }
}
