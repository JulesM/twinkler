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
            'all_expenses'   => $this->getAllExpensesAction(),
            'my_expenses'    => $this->getMyExpensesAction(),
            'other_expenses' => $this->getOtherExpensesAction(),
            'total_paid'     => $this->getTotalPaidAction(),
            'total_owed'     => $this->getTotalOwedAction(),
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
        $expense_repository = $this->container->get('tk_expense.expenses');
        return $expense_repository->getAllExpenses($this->getUser());
    }

    private function getMyExpensesAction()
    {
        return $this->getUser()->getMyExpenses();
    }

    private function getOtherExpensesAction()
    {
        $expense_repository = $this->container->get('tk_expense.expenses');
        return $expense_repository->getOtherExpenses($this->getUser());
    }

    private function getTotalPaidAction()
    {
        $expense_repository = $this->container->get('tk_expense.expenses');
        return $expense_repository->getTotalPaid($this->getUser());
    }

    private function getTotalOwedAction()
    {
        $expense_repository = $this->container->get('tk_expense.expenses');
        return $expense_repository->getTotalOwed($this->getUser());
    }
}