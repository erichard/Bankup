<?php

namespace Erichard\BankupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    public function summaryAction()
    {
        $accounts = $this
            ->getDoctrine()
            ->getRepository('ErichardBankupBundle:Account')
            ->findAll()
        ;

        return $this->render(
            'ErichardBankupBundle:Account:summary.html.twig',
            array(
                'accounts' => $accounts
            )
        );
    }
}
