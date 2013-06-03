<?php

namespace Tk\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExpenseController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkGroupBundle:Expenses:index.html.twig');
    }
}