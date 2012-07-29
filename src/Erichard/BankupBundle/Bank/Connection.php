<?php

namespace Erichard\BankupBundle\Bank;

use Knab\Bank;

class Connection extends Bank
{

    public function __construct($name, array $options)
    {

        $backend = new $options['backend'];
        $backend->setCredentials($options);
        $this->setBackend($backend);
    }
}
