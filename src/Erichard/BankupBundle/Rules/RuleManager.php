<?php

namespace Erichard\BankupBundle\Rules;

use Erichard\BankupBundle\Entity\Operation;

class RuleManager implements \IteratorAggregate
{
    private $rules;

    public function __construct()
    {
        $this->rules = new \SplPriorityQueue();
        $this->rules->setExtractFlags(\SplPriorityQueue::EXTR_DATA);
    }

    public function addRule(RuleInterface $rules, $priority = 50)
    {
        $this->rules->insert($rules, $priority);
    }

    public function processOne(Operation $operation)
    {
        $rules = clone $this->rules;
        $rules->top();

        foreach($rules as $rule) {
            $processedOperation = $rule->process($operation);

            if (!$processedOperation instanceof Operation) {
                throw new \RuntimeException(sprintf(
                    "Method process() of the '%s' rule must return a Erichard\BankupBundle\Entity\Operation class",
                    $rule->getName()
                ));
            }
        }

        return $operation;
    }


    /**
     * @{inheritedDoc}
     */
    public function getIterator() {
        return $this->rules;
    }
}
