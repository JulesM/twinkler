<?php

namespace Tk\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tk\UserBundle\Entity\User;
use Tk\UserBundle\Form\UserType;

class ProfileController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkUserBundle:Profile:show.html.twig', array(
            'balances' => $this->getBalancesAction(),
            ));
    }

    private function getBalancesAction()
    {
        $expenses_service = $this->container->get('tk_expense.expenses');

        $balances = array();
        foreach($this->getUser()->getTGroups() as $group){
            $all_balances = $expenses_service->getBalances($group);
            foreach($all_balances as $balance){
                if($balance[0] == $this->getUser()){
                    $balances[$group->getId()] = $balance[1];
                }
            } 
        }

        return $balances;
    }
}