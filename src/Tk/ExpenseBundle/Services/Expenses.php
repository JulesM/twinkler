<?php
//src/Tk/ExpenseBundle/Services/Expenses.php

namespace Tk\ExpenseBundle\Services;

class Expenses {

	protected $em;

	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		$this->em = $em;
	}

	public function getAllExpenses($user, $group)
    {
    	$all_expenses_col = $group->getExpenses();
        $all_expenses = array();

    	foreach($all_expenses_col as $expense){
    		$all_expenses[] = [$expense, $this->forYou($user, $expense)];
    	}

    	return $all_expenses;
    }

    public function getMyExpenses($user, $group)
    {
        $all_expenses = $group->getExpenses();
        $my_expenses = array();

        foreach($all_expenses as $expense){
            if($expense->getOwner() == $user){
                $my_expenses[] = [$expense, $this->forYou($user, $expense)];
            }else{}
        }

        return $my_expenses;
    }
    
    public function getOtherExpenses($user, $group)
    {
    	$all_expenses = $group->getExpenses();

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

    public function getTotalPaid($user, $group)
    {
        $all_expenses = $group->getExpenses();

    	$sum = 0;
    	foreach($all_expenses as $expense){
    		$sum += $expense->getAmount();
    	}

    	return $sum;
    }

    public function getTotalPaidByMe($user, $group)
    {
        $sum = 0;
        foreach($this->getMyExpenses($user, $group) as $expense){
            $sum += $expense[0]->getAmount();
        }

        return $sum;
    }

    public function getTotalSupposedPaid($user, $group)
    {
        $all_expenses = $group->getExpenses();

        $sum = 0;
        foreach($all_expenses as $expense){
            $sum += $this->forYou($user, $expense);
        }

        return $sum;
    }

    public function getTotalPaidForMe($user, $group)
    {
    	$sum = 0;
    	$other_expenses = $this->getOtherExpenses($user, $group);
    	foreach($other_expenses as $expense){
    		$sum += $expense[1];
    	}

    	return $sum;
    }

    public function getBalances($group)
    {
        $all_users = $group->getMembers();

        $balances = array();
        foreach($all_users as $user){
            $balances[]=[$user, $this->getBalance($user, $group)];
        }
        return $balances;
    }

    private function getBalance($user, $group)
    {
        return $balance = $this->getTotalPaidByMe($user, $group) - $this->getTotalSupposedPaid($user, $group);
    }

    public function getCurrentDebts($group)
    {
        $balances = $this->getBalances($group);

        $payments = array();
        $positive = array();
        $negative = array();

        foreach($balances as $balance){

            if ($balance[1] > 0){
                $positive[$balance[0]->getUsername()] = $balance[1]; 
            }
            elseif ($balance[1] < 0){
                $negative[$balance[0]->getUsername()] = $balance[1];
            }
            else{}
        }

        foreach($positive as $key1 => $value1){
            foreach($negative as $key2 => $value2){
                if ($value1 == -$value2){
                    $payments[] = array($key2, $value1, $key1);
                    $positive[$key1]= 0;
                    $negative[$key2]= 0;
                }
            }
        }

        arsort($positive);
        asort($negative);

        if (current($positive) < 0.01) { $continue = false; } else { $continue = true; }

        while ($continue){

            reset($positive);
            reset($negative);

            $cp = current($positive);
            $cn = current($negative);
            $kp = key($positive);
            $kn = key($negative);
            $min = min($cp,-$cn);

            $payments[] = array($kn, $min, $kp);

            $positive[$kp] -= $min;
            $negative[$kn] += $min;

            arsort($positive);
            asort($negative);
            reset($positive);
            reset($negative);

            if (current($positive) < 0.01) { $continue = false; } else { $continue = true; }
        }

        return $payments;
    }
}