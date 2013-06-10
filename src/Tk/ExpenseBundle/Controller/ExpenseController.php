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
            'debts'               => $this->getCurrentDebtsAction(),
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
            $member = $this->getUser()->getCurrentMember();
            $expense->setAuthor($member);
            $expense->setGroup($member->getTGroup());
    		$em->persist($expense);
    		$em->flush();

        	return $this->redirect($this->generateUrl('tk_expense_homepage'));
    	}}

    	return $this->render('TkExpenseBundle::new.html.twig', array(
    		'form' => $form->createView(),
    	));
    }

    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $expense = $em->getRepository('TkExpenseBundle:Expense')->find($id);
        
        $em->remove($expense);
        $em->flush();

        return $this->indexAction();
    }

    private function getAllExpensesAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getAllExpenses($member, $member->getTGroup());
    }

    private function getMyExpensesAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getMyExpenses($member, $member->getTGroup());
    }

    private function getOtherExpensesAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getOtherExpenses($member, $member->getTGroup());
    }

    private function getTotalPaidAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getTotalPaid($member->getTGroup());
    }

    private function getTotalPaidByMeAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getTotalPaidByMe($member, $member->getTGroup());
    }

    private function getTotalSupposedPaidAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getTotalSupposedPaid($member, $member->getTGroup());
    }

    private function getTotalPaidForMeAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getTotalPaidForMe($member, $member->getTGroup());
    }

    private function getBalancesAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getBalances($member->getTGroup());
    }

    private function getCurrentDebtsAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getCurrentDebts($member->getTGroup());
    }
}