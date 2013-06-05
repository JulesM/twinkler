<?php
//src/Tk/ExpenseBundle/Services/Expenses.php

namespace Tk\ExpenseBundle\Services;

class Expenses {

	protected $em;

	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		$this->em = $em;
	}
    
    public function getOtherExpenses($user)
    {
    	$expense_repository = $this->em->getRepository('TkExpenseBundle:Expense');
    	$all_expenses = $expense_repository->findAll();

    	$other_expenses = array();
    	foreach($all_expenses as $expense){
    		if ($expense->getOwner() == $user){
    		}else{
    			$other_expenses[] = $expense;
    		}
    	}

    	return $other_expenses;
    }
}