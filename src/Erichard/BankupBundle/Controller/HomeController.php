<?php

namespace Erichard\BankupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homeAction()
    {
        return $this->render('ErichardBankupBundle:Home:home.html.twig');
    }
}
