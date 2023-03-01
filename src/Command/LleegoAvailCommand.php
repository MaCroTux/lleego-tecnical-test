<?php

namespace App\Command;

use App\Flight\Application\GetInfoFromFlightSegmentUseCase;
use App\Flight\Application\GetInfoFromFlightSegmentUseResponse;
use App\Flight\Domain\InvalidDateException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'lleego:avail',
    description: 'Devuelve la disponibilidad de vuelos',
)]
class LleegoAvailCommand extends Command
{
    const TABLE_HEADERS = [
        'Origin Code',
        'Origin Name',
        'Destination Code',
        'Destination Name',
        'Start',
        'End',
        'Transport Number',
        'Company Code',
        'Company Name'
    ];

    public function __construct(private readonly GetInfoFromFlightSegmentUseCase $getInfoFromFlightSegmentUseCase)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('origin', InputArgument::REQUIRED, 'Origin')
            ->addArgument('destination', InputArgument::REQUIRED, 'Destination')
            ->addArgument('date', InputArgument::REQUIRED, 'Date')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $origin = $input->getArgument('origin');
        $destination = $input->getArgument('destination');
        $date = $input->getArgument('date');

        try {
            $response = $this->getInfoFromFlightSegmentUseCase->__invoke($origin, $destination, $date);
            $tableRows = $this->createRowsFromResponse($response);
        } catch (InvalidDateException) {
            $io->error('Invalid date');
            return Command::FAILURE;
        }

        if ($tableRows === []) {
            $io->warning('No flights found');
            return Command::SUCCESS;
        }

        $table = new Table($output);
        $table
            ->setHeaders(self::TABLE_HEADERS)
            ->setRows($tableRows);

        $table->render();

        return Command::SUCCESS;
    }

    private function createRowsFromResponse(array $response): array
    {
        return array_map(function (GetInfoFromFlightSegmentUseResponse $item) {
            return [
                $item->getOriginCode(),
                $item->getOriginName(),
                $item->getDestinationCode(),
                $item->getDestinationName(),
                $item->getStart(),
                $item->getEnd(),
                $item->getTransportNumber(),
                $item->getCompanyCode(),
                $item->getCompanyName(),
            ];
        }, $response);
    }
}
