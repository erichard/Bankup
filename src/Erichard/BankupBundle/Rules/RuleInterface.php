<?php

namespace Erichard\BankupBundle\Rules;

use Erichard\BankupBundle\Entity\Operation;

interface RuleInterface
{
    public function process(Operation $operation);

    public function getName();
}
