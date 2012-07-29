<?php

namespace Erichard\BankupBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Erichard\BankupBundle\Entity\Operation;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SyncCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bankup:sync')
            ->setDescription('Sync all registred bank')
            ->addOption('max-history', 'm', InputOption::VALUE_REQUIRED, 'Maximum number of operation per account to synchronize. 0 = unlimited.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $container           = $this->getContainer();
        $bankManager         = $container->get('erichard_bankup.manager');
        $em                  = $container->get('doctrine')->getManager();
        $accountRepository   = $container->get('doctrine')->getRepository('ErichardBankupBundle:Account');
        $operationRepository = $container->get('doctrine')->getRepository('ErichardBankupBundle:Operation');
        $accounts            = $bankManager->getAccounts();
        $limit               = $input->getOption('max-history') !== null ? (int) $input->getOption('max-history') : 15;

        if ($limit == 0) {
            $msg = sprintf(
                '<info>Synchronizing %d accounts with no operation count limit...</info>',
                count($accounts)
            );
        } else {
            $msg = sprintf(
                '<info>Synchronizing %d accounts looking at %d first operations...</info>',
                count($accounts),
                $limit
            );
        }

        $output->writeln($msg);

        $countOperation = 0;
        foreach ($accounts as $remoteAccount) {
            $account = $accountRepository->findOrCreate($remoteAccount->getId());

            $account->setBalance($remoteAccount->getBalance());
            $account->setName($this->humanize($remoteAccount->getLabel()));
            $em->persist($account);

            $operations = $remoteAccount->getHistory($limit);
            foreach ($operations as $remoteOperation) {
                $id = $operationRepository->createId($remoteOperation);

                if (!$operationRepository->find($id)) {
                    $operation = new Operation();
                    $operation->setId($id);
                    $operation->setLabel($remoteOperation->getLabel());
                    $operation->setBalance($remoteOperation->getAmount());
                    $operation->setDate($remoteOperation->getDate());

                    $account->addOperation($operation);
                    $em->persist($operation);
                    $countOperation++;
                }
            }
        }
        $output->writeln(sprintf('<comment>Found %d new operations.</comment>', $countOperation));

        $em->flush();
    }

    private function humanize($text)
    {
        return ucfirst(trim(strtolower(preg_replace('/[_\s]+/', ' ', $text))));
    }
}
