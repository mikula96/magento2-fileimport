<?php

namespace SmSoftware\Import\Console\Command;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Console\Cli;
use SmSoftware\Import\Model\Service\ImportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Import extends Command
{
    const FILENAME = 'filename';
    private ImportService $_importService;
    private DirectoryList $_directoryList;

    public function __construct(
        DirectoryList $directoryList,
        ImportService $importService,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->_directoryList = $directoryList;
        $this->_importService = $importService;
    }

    protected function configure()
    {
        $this->setName('smsoftware:import')
            ->addArgument(self::FILENAME, InputArgument::REQUIRED, 'Filename')
            ->setDescription('Import data from CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try{
            $filename = $input->getArgument(self::FILENAME);

            $filepath = $this->_directoryList->getPath(DirectoryList::VAR_DIR).'/import/'.$filename;
            $this->_importService->import($filepath);
            $output->writeln("<info>".date('Y-m-d H:i:s')."Import started...</info>");
            $output->writeln("<info>".date('Y-m-d H:i:s')."Import finished</info>");
        }catch (\Exception $e){
            $output->writeln("<error>{$e->getMessage()}</error>");
            return Cli::RETURN_FAILURE;
        }
        return Cli::RETURN_SUCCESS;
    }
}