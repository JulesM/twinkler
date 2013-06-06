<?php

namespace Tk\ExpenseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tk\ExpenseBundle\Entity\Expense;
use Tk\ExpenseBundle\Form\ExpenseType;

class ExpenseController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkExpenseBundle::index.html.twig', array(
            'all_expenses'        => $this->getAllExpensesAction(),
            'my_expenses'         => $this->getMyExpensesAction(),
            'other_expenses'      => $this->getOtherExpensesAction(),
            'total_paid'          => $this->getTotalPaidAction(),
            'total_paid_by_me'    => $this->getTotalPaidByMeAction(),
            'total_paid_supposed' => $this->getTotalSupposedPaidAction(),
            'total_paid_for_me'   => $this->getTotalPaidForMeAction(),
            'balances'            => $this->getBalancesAction(),
            ));
    }

    public function newAction()
    {
    	$expense = new Expense();
    	$expense->setAddedDate(new \DateTime('now'));
        $expense->setDate(new \Datetime('today'));
    	$expense->setActive(true);

        $form = $this->createForm(new ExpenseType(), $expense);
    	

        $request = $this->get('request');

        if ($request->isMethod('POST')) {
            
            $form->bind($request);

            if ($form->isValid()) {          
        
    		$em = $this->getDoctrine()->getEntityManager();
    		$em->persist($expense);
    		$em->flush();

        	return $this->redirect($this->generateUrl('tk_expense_homepage'));
    	}}

    	return $this->render('TkExpenseBundle::new.html.twig', array(
    		'form' => $form->createView(),
    	));
    }

    private function getAllExpensesAction()
    {
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getAllExpenses($this->getUser());
    }

    private function getMyExpensesAction()
    {
        return $this->getUser()->getMyExpenses();
    }

    private function getOtherExpensesAction()
    {
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getOtherExpenses($this->getUser());
    }

    private function getTotalPaidAction()
    {
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getTotalPaid($this->getUser());
    }

    private function getTotalPaidByMeAction()
    {
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getTotalPaidByMe($this->getUser());
    }

    private function getTotalSupposedPaidAction()
    {
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getTotalSupposedPaid($this->getUser());
    }

    private function getTotalPaidForMeAction()
    {
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getTotalPaidForMe($this->getUser());
    }

    private function getBalancesAction()
    {
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getBalances($this->getUser());
    }

    private function getCurrentDebtsAction()
    {
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getCurrentDebts($this->getUser());
    }
}