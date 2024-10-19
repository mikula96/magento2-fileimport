<?php

namespace SmSoftware\Import\Console\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\State;
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
    private State $_state;

    public function __construct(
        DirectoryList $directoryList,
        ImportService $importService,
        State $state,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->_directoryList = $directoryList;
        $this->_importService = $importService;
        $this->_state = $state;
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
            $output->writeln("<info>".date('Y-m-d H:i:s')." Import started...</info>");
            $this->_state->setAreaCode(Area::AREA_CRONTAB);
            $filename = $input->getArgument(self::FILENAME);

            $filepath = $this->_directoryList->getPath(DirectoryList::VAR_DIR).'/import/'.$filename;
            $this->_importService->import($filepath);
            $output->writeln("<info>".date('Y-m-d H:i:s')." Import finished</info>");
        }catch (\Exception $e){
            $output->writeln("<error>{$e->getMessage()}\n{$e->getTraceAsString()}</error>");
            return Cli::RETURN_FAILURE;
        }
        return Cli::RETURN_SUCCESS;
    }
}