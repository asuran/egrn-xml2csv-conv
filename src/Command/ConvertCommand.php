<?php

namespace EgrnXml2CsvConv\Command;

use EgrnXml2CsvConv\DTOBuilder\ExtractObjectDTOBuilder;
use EgrnXml2CsvConv\Reader\XMLReader;
use EgrnXml2CsvConv\RowBuilder\RowBuilder;
use EgrnXml2CsvConv\Writer\CsvWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ConvertCommand extends Command
{
    private const COLUMN_TITLES = [
        'Номер помещения',
        'Назначение помещения (жилое/нежилое)',
        'S, кв.м',
        'Адрес',
        'Номер на экспликации',
        'ФИО собственника',
        'Наименование организации собственника',
        'Доля в праве на помещение',
        'Номер регистрации права собственности',
        'Дата регистрации права собственности',
        'Дата прекращения права',
    ];

    protected static $defaultName = 'convert';

    protected function configure(): void
    {
        $this->addArgument('inputPath', InputArgument::REQUIRED, 'Path to input file or directory');
        $this->addArgument('outputFile', InputArgument::REQUIRED, 'Path to output file');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $inputPath = $input->getArgument('inputPath');
            $outputFile = $input->getArgument('outputFile');

            if (file_exists($inputPath) === false) {
                $output->writeln(sprintf('Input file %s does not exists', $inputPath));

                return Command::INVALID;
            }

            $inputFiles = [];

            if (is_dir($inputPath) === true) {
                $fileList = scandir($inputPath);

                foreach ($fileList as $filepath) {
                    if (pathinfo($filepath, PATHINFO_EXTENSION) === 'xml') {
                        $inputFiles[] = realpath($inputPath . '/' . $filepath);
                    }
                }
            } else {
                $inputFiles[] = realpath($inputPath);
            }

            $output->writeln(sprintf('%s files to parse', count($inputFiles)));
            $output->writeln(sprintf('Writing result into %s', $outputFile));

            CsvWriter::writeRow($outputFile, self::COLUMN_TITLES);

            foreach ($inputFiles as $inputFile) {
                $output->writeln(sprintf('Parsing %s', realpath($inputFile)));

                $data = XMLReader::readXML($inputFile);
                $output->writeln(var_export($data, true));

                $extractObjectDTO = ExtractObjectDTOBuilder::build($data);

                foreach (RowBuilder::build($extractObjectDTO) as $row) {
                    $output->writeln(var_export($row, true));

                    CsvWriter::writeRow($outputFile, $row);
                }
            }

            $output->writeln(sprintf('%s files parsed', count($inputFiles)));
            $output->writeln('Done');
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
