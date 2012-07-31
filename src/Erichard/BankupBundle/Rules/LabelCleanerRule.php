<?php

namespace Erichard\BankupBundle\Rules;

use Erichard\BankupBundle\Rules\RuleInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Erichard\BankupBundle\Entity\Operation;
use Erichard\BankupBundle\Entity\Tag;

/**
 * @TODO: Rename in LbpLabelCleanerRule
 */
class LabelCleanerRule implements RuleInterface
{
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getName()
    {
        return 'label_cleaner';
    }

    public function process(Operation $operation)
    {
        $label = $operation->getRawLabel();

        $manager = $this->doctrine->getManager();

        // Clean "prélèvelement"
        $label = preg_replace('/prelevement(?: de)?/im', '', $label, -1, $count);

        if ($count > 0 ) {
            $tag = new Tag();
            $tag->setName('Prélèvement');
            $operation->addTag($tag);
            $manager->persist($tag);
        }

        // Clean "carte no/numero 123"
        $label = preg_replace('/achat cb/im', '', $label, -1, $count);
        if ($count > 0) {
            $cbTag = new Tag();
            $cbTag->setName('CB');
            $operation->addTag($cbTag);
            $manager->persist($cbTag);
        }

        // Clean "carte no/numero 123"
        if(preg_match('/carte\s+(?:no|numero)\s+([0-9]+)/im', $label, $matches)) {
            if (isset($cbTag)) {
                $operation->removeTag($cbTag);
            }

            $tag = new Tag();
            $tag->setName('CB #'.$matches[1]);
            $operation->addTag($tag);
            $manager->persist($tag);

            $label = preg_replace('/carte\s+(?:no|numero)\s+([0-9]+)/im', '', $label);
        }

        // Clean date
        $label = preg_replace(
            '(((0[1-9])|(1\d)|(2\d)|(3[0-1]))\.'. // day
            '((0[1-9])|(1[0-2]))\.'.               // month
            '(\d{2}))',                           // year
            '',
            $label
        );

        // Humanize label
        $label = $this->humanize($label);

        // Set the definitive label
        $operation->setLabel($label);

        return $operation;
    }


    private function humanize($text)
    {
        return ucfirst(trim(strtolower(preg_replace('/[_\s]+/', ' ', $text))));
    }
}
