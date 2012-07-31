<?php

namespace Erichard\BankupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OperationController extends Controller
{
    public function historyAction($max = 30)
    {
        $operations = $this
            ->getDoctrine()
            ->getEntityManager()
            ->createQuery('SELECT o, a FROM ErichardBankupBundle:Operation o INNER JOIN o.account a ORDER BY o.date DESC')
            ->setMaxResults($max)
            ->getResult()
        ;

        return $this->render(
            'ErichardBankupBundle:Operation:history.html.twig',
            array(
                'operations' => $operations
            )
        );
    }
}
