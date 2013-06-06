<?php
//src/Tk/ExpenseBundle/Services/Expenses.php

namespace Tk\ExpenseBundle\Services;

class Expenses {

	protected $em;

	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		$this->em = $em;
	}

	public function getAllExpenses($user)
    {
    	$expense_repository = $this->em->getRepository('TkExpenseBundle:Expense');
    	$all_expenses_col = $expense_repository->findAll();
    	$all_expenses = array();

    	foreach($all_expenses_col as $expense){
    		$all_expenses[] = [$expense, $this->forYou($user, $expense)];
    	}

    	return $all_expenses;
    }
    
    public function getOtherExpenses($user)
    {
    	$expense_repository = $this->em->getRepository('TkExpenseBundle:Expense');
    	$all_expenses = $expense_repository->findAll();

    	$other_expenses = array();
    	foreach($all_expenses as $expense){
    		if ($expense->getOwner() == $user){
    		}else{
    			$other_expenses[] = [$expense, $this->forYou($user, $expense)];
    		}
    	}

    	return $other_expenses;
    }

    private function forYou($user, $expense)
    {
    	$users = $expense->getUsers()->toArray();
    	if(in_array($user, $users)){
    		return ($expense->getAmount())/(sizeof($users));
    	}else{
    		return 0;
    	}
    }

    public function getTotalPaid($user)
    {
        $expense_repository = $this->em->getRepository('TkExpenseBundle:Expense');
        $all_expenses = $expense_repository->findAll();

    	$sum = 0;
    	foreach($all_expenses as $expense){
    		$sum += $expense->getAmount();
    	}

    	return $sum;
    }

    public function getTotalPaidByMe($user)
    {
        $sum = 0;
        foreach($user->getMyExpenses() as $expense){
            $sum += $expense->getAmount();
        }

        return $sum;
    }

    public function getTotalSupposedPaid($user)
    {
        $expense_repository = $this->em->getRepository('TkExpenseBundle:Expense');
        $all_expenses = $expense_repository->findAll();

        $sum = 0;
        foreach($all_expenses as $expense){
            $sum += $this->forYou($user, $expense);
        }

        return $sum;
    }

    public function getTotalPaidForMe($user)
    {
    	$sum = 0;
    	$other_expenses = $this->getOtherExpenses($user);
    	foreach($other_expenses as $expense){
    		$sum += $expense[1];
    	}

    	return $sum;
    }

    public function getBalances($user)
    {
        $user_repository = $this->em->getRepository('TkUserBundle:User');
        $all_users = $user_repository->findAll();

        $balances = array();
        foreach($all_users as $user){
            $balances[]=[$user, $this->getBalance($user)];
        }
        return $balances;
    }

    private function getBalance($user)
    {
        return $balance = $this->getTotalPaidByMe($user) - $this->getTotalSupposedPaid($user);
    }

    public function getCurrentDebts($user)
    {

    }
}