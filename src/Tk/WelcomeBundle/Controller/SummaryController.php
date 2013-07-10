<?php

namespace Tk\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SummaryController extends Controller
{
    public function summaryAction($id, $token)
    {
        $group = $this->getDoctrine()->getRepository('TkGroupBundle:TGroup')->find($id);

        if ($token != $group->getInvitationToken()){
            throw new AccessDeniedException('You try to access a wrong Url');
        }else{
            return $this->render('TkWelcomeBundle:Invitation:summary.html.twig', array(
                'group'               => $group,
                'all_expenses'        => $this->getAllExpensesAction(),
                'total_paid'          => $this->getTotalPaidAction(),
                'total_paid_by_me'    => $this->getTotalPaidByMeAction(),
                'total_paid_supposed' => $this->getTotalSupposedPaidAction(),
                'debts'               => $this->getCurrentDebtsAction(),
                ));
        }
    }

    private function getAllExpensesAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getAllExpenses($member);
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
        return $expenses_service->getTotalPaidByMe($member);
    }

    private function getTotalSupposedPaidAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getTotalSupposedPaid($member);
    }

    private function getCurrentDebtsAction()
    {
        $member = $this->getUser()->getCurrentMember();
        $expenses_service = $this->container->get('tk_expense.expenses');
        return $expenses_service->getCurrentDebts($member->getTGroup());
    }
}
