<?php

namespace Erichard\BankupBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Erichard\BankupBundle\DependencyInjection\Compiler\RegisterBankConnectionPass;
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
    }
  }
