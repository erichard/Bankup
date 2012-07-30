<?php

namespace Erichard\BankupBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Dumper;

class ExportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bankup:export')
            ->setDescription('Export all operations')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'Export format (yml, csv)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $operations = $this->getContainer()
            ->get('doctrine')
            ->getRepository('ErichardBankupBundle:Operation')
            ->createQueryBuilder('o')
            ->addSelect('a')
            ->innerJoin('o.account', 'a')
            ->orderBy('o.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;

        $format = $input->getOption('format');
        $format = $format?: 'yml';

        switch ($format) {
            case 'csv' :
                throw new \RuntimeException('Format "csv" will be implemented soon !');

            case 'yml' :
                $export = $this->exportYaml($operations);
                break;

            default:
                throw new \RuntimeException(
                    sprintf('Format %s is not supported', $format)
                );
        }

        $output->writeln($export);
    }

    private function exportYaml(array $operations)
    {
        $dumper = new Dumper();

        $operations = array_map(function($op){
            return array(
                'account' => $op->getAccount()->getName(),
                'date'    => $op->getDate()->format('d/m/Y'),
                'label'   => $op->getLabel(),
                'balance' => $op->getBalance()/100,
            );
        }, $operations);

        $yaml = $dumper->dump($operations, 2);

        return $yaml;
    }
}
