<?php

namespace Erichard\BankupBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OperationRepository extends EntityRepository
{
    public function findOrCreate(\Knab\Operation $knabOperation)
    {
        $id = $this->createId($knabOperation);

        $operation = $this->find($id);

        if (null === $operation) {
            $operation = new Operation();
            $operation->setId($id);
        }

        return $operation;
    }

    public function createId(\Knab\Operation $operation)
    {
        return sha1(implode(' ', array(
            $operation->getDate()->format('d/m/Y'),
            $operation->getLabel(),
            $operation->getAmount()
        )));
    }


}
