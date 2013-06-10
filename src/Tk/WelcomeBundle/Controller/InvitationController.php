<?php

namespace Tk\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InvitationController extends Controller
{
    public function invitationLoginAction($id, $token)
    {
        $user = $this->getUser();
        $member = $this->getDoctrine()->getRepository('TkUserBundle:Member')->find($id);

        if ($token != $member->getInvitationToken()){
            throw new AccessDeniedException('The invitation has expired or the url is wrong');
        }else{

            $this->get('session')->set('invitation_id', $id);

            if ($user){

                $member->setUser($user);
                $member->setInvitationToken(null);
                $user->setCurrentMember($member);
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($member);
                $em->flush();

                return $this->redirect($this->generateUrl('tk_expense_homepage'));

            }else{

                return $this->render('TkWelcomeBundle:Invitation:login-invitation.html.twig', array(
                	'member' => $member
                	));

            }
        }
    }
}
