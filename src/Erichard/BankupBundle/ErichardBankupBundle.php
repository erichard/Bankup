<?php

namespace Erichard\BankupBundle;

use Erichard\BankupBundle\DependencyInjection\Compiler\RegisterBankConnectionPass;
use Erichard\BankupBundle\DependencyInjection\Compiler\RegisterRulesPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ErichardBankupBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterBankConnectionPass());
        $container->addCompilerPass(new RegisterRulesPass());
    }
  }
