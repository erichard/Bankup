<?php

namespace Erichard\BankupBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AccountRepository extends EntityRepository
{
    public function findOrCreate($id)
    {
        $account = $this->find($id);

        if (null === $account) {
            $account = new Account();
            $account->setId($id);
        }

        return $account;
    }
}
